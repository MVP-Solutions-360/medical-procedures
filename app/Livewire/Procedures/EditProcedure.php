<?php

namespace App\Livewire\Procedures;

use App\Models\Procedure;
use App\Models\ProcedureImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProcedure extends Component
{
    use WithFileUploads;

    public Procedure $procedure;

    public $name;
    public $slugInput;
    public $category;
    public $summary;
    public $description;
    public $anesthesia;
    public $hospitalization;
    public $surgery_time_min;
    public $surgery_time_max;
    public $initial_recovery_weeks;
    public $final_results_weeks;
    public $risk_level;
    public $is_active;

    public $featuredImageUpload;
    public $videoUpload;
    public $galleryUploads = [];

    public function mount(Procedure $procedure): void
    {
        $this->procedure = $procedure;
        $this->fillFromModel();
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slugInput' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('procedures', 'slug')->ignore($this->procedure->id),
            ],
            'category' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'anesthesia' => ['nullable', 'string', 'max:255'],
            'hospitalization' => ['nullable', 'string', 'max:255'],
            'surgery_time_min' => ['nullable', 'integer', 'min:0'],
            'surgery_time_max' => ['nullable', 'integer', 'min:0'],
            'initial_recovery_weeks' => ['nullable', 'integer', 'min:0'],
            'final_results_weeks' => ['nullable', 'integer', 'min:0'],
            'risk_level' => ['nullable', 'in:bajo,medio,alto'],
            'is_active' => ['required'],
        ];
    }

    public function updateProcedure(): void
    {
        $data = $this->validate();

        $slug = $data['slugInput']
            ? Str::slug($data['slugInput'])
            : Str::slug($data['name']);

        $this->procedure->update([
            'name' => $data['name'],
            'slug' => $slug,
            'category' => $data['category'],
            'summary' => $data['summary'],
            'description' => $data['description'],
            'anesthesia' => $data['anesthesia'],
            'hospitalization' => $data['hospitalization'],
            'surgery_time_min' => $data['surgery_time_min'],
            'surgery_time_max' => $data['surgery_time_max'],
            'initial_recovery_weeks' => $data['initial_recovery_weeks'],
            'final_results_weeks' => $data['final_results_weeks'],
            'risk_level' => $data['risk_level'] ?? 'medio',
            'is_active' => filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN),
        ]);

        $this->procedure->refresh();
        $this->fillFromModel();

        session()->flash('procedure_updated', 'Procedimiento actualizado correctamente.');
    }

    public function updateFeaturedImage(): void
    {
        $this->validate([
            'featuredImageUpload' => 'required|image|max:2048',
        ]);

        $path = $this->featuredImageUpload->store('procedures/featured', 'public');

        if ($this->procedure->featured_image_path) {
            Storage::disk('public')->delete($this->procedure->featured_image_path);
        }

        $this->procedure->update(['featured_image_path' => $path]);
        $this->refreshProcedure();
        $this->reset('featuredImageUpload');
        session()->flash('media_updated', 'Imagen principal actualizada.');
    }

    public function updateVideo(): void
    {
        $this->validate([
            'videoUpload' => 'required|mimetypes:video/mp4,video/quicktime|max:20480',
        ]);

        $path = $this->videoUpload->store('procedures/videos', 'public');

        if ($this->procedure->video_path) {
            Storage::disk('public')->delete($this->procedure->video_path);
        }

        $this->procedure->update(['video_path' => $path]);
        $this->refreshProcedure();
        $this->reset('videoUpload');
        session()->flash('media_updated', 'Video actualizado correctamente.');
    }

    public function addGalleryImages(): void
    {
        $this->validate([
            'galleryUploads' => 'required|array',
            'galleryUploads.*' => 'image|max:2048',
        ]);

        $nextOrder = ($this->procedure->images()->max('order') ?? 0) + 1;

        foreach ($this->galleryUploads as $upload) {
            $path = $upload->store('procedures/gallery', 'public');

            ProcedureImage::create([
                'procedure_id' => $this->procedure->id,
                'url' => $path,
                'order' => $nextOrder++,
            ]);
        }

        $this->refreshProcedure();
        $this->reset('galleryUploads');
        session()->flash('media_updated', 'Galería actualizada.');
    }

    public function removeGalleryImage(int $imageId): void
    {
        $image = $this->procedure->images()->findOrFail($imageId);
        Storage::disk('public')->delete($image->url);
        $image->delete();

        $this->refreshProcedure();
        session()->flash('media_updated', 'Imagen eliminada.');
    }

    protected function fillFromModel(): void
    {
        $this->procedure->load('images');
        $this->name = $this->procedure->name;
        $this->slugInput = $this->procedure->slug;
        $this->category = $this->procedure->category;
        $this->summary = $this->procedure->summary;
        $this->description = $this->procedure->description;
        $this->anesthesia = $this->procedure->anesthesia;
        $this->hospitalization = $this->procedure->hospitalization;
        $this->surgery_time_min = $this->procedure->surgery_time_min;
        $this->surgery_time_max = $this->procedure->surgery_time_max;
        $this->initial_recovery_weeks = $this->procedure->initial_recovery_weeks;
        $this->final_results_weeks = $this->procedure->final_results_weeks;
        $this->risk_level = $this->procedure->risk_level;
        $this->is_active = $this->procedure->is_active ? '1' : '0';
    }

    protected function refreshProcedure(): void
    {
        $this->procedure = $this->procedure->fresh()->load('images');
    }

    public function render()
    {
        return view('livewire.procedures.edit-procedure');
    }
}
