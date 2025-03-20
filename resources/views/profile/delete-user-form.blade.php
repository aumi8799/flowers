<x-action-section>
    <x-slot name="title">
        {{ __('Ištrinti paskyrą') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Visam laikui ištrinti paskyrą.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ištrynus jūsų paskyrą, visi jos ištekliai ir duomenys bus visam laikui ištrinti. Prieš ištrindami paskyrą atsisiųskite visus duomenis ar informaciją, kurią norite išsaugoti.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Ištrinti paskyrą') }}
            </x-danger-button>
        </div>


        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Ištrinti paskyrą') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Ar tikrai norite ištrinti savo paskyrą? Ištrynus jūsų paskyrą, visi jos ištekliai ir duomenys bus visam laikui ištrinti. Įveskite savo slaptažodį, kad patvirtintumėte, jog norite visam laikui ištrinti savo paskyrą.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4"
                                autocomplete="current-password"
                                placeholder="{{ __('Password') }}"
                                x-ref="password"
                                wire:model="password"
                                wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-danger-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Atšaukti') }}
                    </x-danger-button>

                <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Ištrinti paskyrą') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
