<x-action-section>
    <x-slot name="title">
        {{ __('Dviejų faktorių autentifikacija') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Pridėkite papildomą saugumą prie savo paskyros naudodami dviejų faktorių autentifikaciją.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Baigkite įjungti dviejų faktorių autentifikaciją.') }}
                @else
                    {{ __('Dviejų faktorių autentifikacija įjungta.') }}
                @endif
            @else
                {{ __('Dviejų faktorių autentifikacija nėra įjungta.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600">
            <p>
                {{ __('Kai įjungiama dviejų faktorių autentifikacija, jums bus paprašyta įvesti saugų, atsitiktinį kodą autentifikacijos metu. Šį kodą galite gauti iš savo telefono Google Authenticator programėlės.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('Norėdami baigti įjungti dviejų faktorių autentifikaciją, nuskenuokite šį QR kodą naudodami savo telefono autentifikavimo programėlę arba įveskite nustatymo raktą ir pateikite sugeneruotą OTP kodą.') }}
                        @else
                            {{ __('Dviejų faktorių autentifikacija dabar įjungta. Nuskenuokite šį QR kodą naudodami savo telefono autentifikavimo programėlę arba įveskite nustatymo raktą.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 p-2 inline-block bg-white">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Nustatymo raktas') }}: {{ decrypt($this->user->two_factor_secret) }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('Kodėlis') }}" />

                        <x-input id="code" type="text" name="code" class="block mt-1 w-1/2" inputmode="numeric" autofocus autocomplete="one-time-code"
                            wire:model="code"
                            wire:keydown.enter="confirmTwoFactorAuthentication" />

                        <x-input-error for="code" class="mt-2" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Saugojame šiuos atkūrimo kodus saugiame slaptažodžių tvarkytuve. Jie gali būti naudojami atkuriant prieigą prie jūsų paskyros, jei prarandate dviejų faktorių autentifikavimo įrenginį.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button type="button" wire:loading.attr="disabled">
                        {{ __('Įjungti') }}
                    </x-button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('Sugeneruoti atkūrimo kodus iš naujo') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-button type="button" class="me-3" wire:loading.attr="disabled">
                            {{ __('Patvirtinti') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('Rodyti atkūrimo kodus') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-secondary-button wire:loading.attr="disabled">
                            {{ __('Atšaukti') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-danger-button wire:loading.attr="disabled">
                            {{ __('Išjungti') }}
                        </x-danger-button>
                    </x-confirms-password>
                @endif
            @endif
        </div>
    </x-slot>
</x-action-section>
