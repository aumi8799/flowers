@props(['submit'])

@props(['submit'])
<div class="p-5 mb-3 bg-white border text-center text-gray" style="border-radius: 0;">
    <div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-1 md:gap-6']) }}>
        <x-section-title>
            <x-slot name="title">{{ $title }}</x-slot>
            <x-slot name="description">{{ $description }}</x-slot>
        </x-section-title>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                <form wire:submit="{{ $submit }}">
                    <div class="grid grid-cols-1 gap-4">
                        {{ $form }}
                    </div>
                    @if (isset($actions))
                        <div class="flex items-center justify-end mt-4">
                            {{ $actions }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>