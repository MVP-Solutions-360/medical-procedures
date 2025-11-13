<?php

namespace App\Livewire\Procedures;

use App\Models\Procedure;
use App\Models\ProcedureImage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProcedure extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $category;
    public $summary;
    public $description;
    public $anesthesia;
    public $surgery_time_min;
    public $surgery_time_max;
    public $hospitalization;
    public $initial_recovery_weeks;
    public $final_results_weeks;
    public $risk_level;
    public $is_active = true;
    public $main_image;
    public $gallery_images = [];
    public $procedure_video;

    public $sections = [];
    public $techniques = [];
    public $indications = [];
    public $preops = [];
    public $postops = [];
    public $extras = [];
    public $risks = [];
    public $images = [];
    public $metadata = [];
    public $success = false;
    public $success_message = '';
    public $error_message = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'anesthesia' => 'nullable|string|max:255',
            'surgery_time_min' => 'nullable|integer|min:0',
            'surgery_time_max' => 'nullable|integer|min:0',
            'hospitalization' => 'nullable|string|max:255',
            'initial_recovery_weeks' => 'nullable|integer|min:0',
            'final_results_weeks' => 'nullable|integer|min:0',
            'risk_level' => 'nullable|in:bajo,medio,alto',
            'is_active' => 'boolean',
            'main_image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'procedure_video' => 'nullable|mimetypes:video/mp4,video/quicktime|max:20480',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre debe tener menos de 255 caracteres',
            'main_image.image' => 'La imagen principal debe ser un archivo de imagen válido',
            'gallery_images.*.image' => 'Cada elemento de la galería debe ser una imagen válida',
            'procedure_video.mimetypes' => 'El video debe ser un archivo MP4 o MOV',
        ];
    }

    public function updatedName($value): void
    {
        $this->slug = Str::slug($value ?? '');
    }

    public function create(): void
    {
        $this->validate();

        $slug = $this->generateUniqueSlug();

        $featuredPath = $this->main_image
            ? $this->main_image->store('procedures/featured', 'public')
            : null;

        $videoPath = $this->procedure_video
            ? $this->procedure_video->store('procedures/videos', 'public')
            : null;

        $procedure = Procedure::create([
            'name' => $this->name,
            'slug' => $slug,
            'category' => $this->category,
            'summary' => $this->summary,
            'description' => $this->description,
            'featured_image_path' => $featuredPath,
            'video_path' => $videoPath,
            'anesthesia' => $this->anesthesia,
            'surgery_time_min' => $this->surgery_time_min,
            'surgery_time_max' => $this->surgery_time_max,
            'hospitalization' => $this->hospitalization,
            'initial_recovery_weeks' => $this->initial_recovery_weeks,
            'final_results_weeks' => $this->final_results_weeks,
            'risk_level' => $this->risk_level ?? 'medio',
            'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
        ]);

        if (!empty($this->gallery_images)) {
            foreach ($this->gallery_images as $index => $image) {
                $galleryPath = $image->store('procedures/gallery', 'public');

                ProcedureImage::create([
                    'procedure_id' => $procedure->id,
                    'url' => $galleryPath,
                    'order' => $index + 1,
                ]);
            }
        }

        $this->resetForm();
        $this->success = true;
        $this->success_message = 'Procedimiento creado correctamente.';
    }

    public function resetForm(): void
    {
        $this->reset([
            'name',
            'slug',
            'category',
            'summary',
            'description',
            'anesthesia',
            'surgery_time_min',
            'surgery_time_max',
            'hospitalization',
            'initial_recovery_weeks',
            'final_results_weeks',
            'risk_level',
            'is_active',
            'main_image',
            'gallery_images',
            'procedure_video',
        ]);

        $this->is_active = true;
        $this->gallery_images = [];
    }

    protected function generateUniqueSlug(): string
    {
        $baseSlug = Str::slug($this->name ?? Str::random(6));
        $slug = $baseSlug;
        $counter = 1;

        while (Procedure::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    public function render()
    {
        return view('livewire.procedures.create-procedure');
    }
}
