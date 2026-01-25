<div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-0 px-4 sm:px-0 relative">
    <!-- Blue Gradient Background -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200"></div>

    <div class="w-full max-w-sm sm:max-w-2xl mt-4 sm:mt-6 px-4 sm:px-6 py-6 sm:py-8 bg-white/95 backdrop-blur-sm shadow-lg sm:shadow-xl overflow-hidden rounded-lg sm:rounded-2xl border border-blue-100">
        <!-- Logo Image -->
        <div class="mb-4 sm:mb-6 text-center">
            <img 
                src="{{ asset('images/spcc-logo.png') }}" 
                alt="SPCC Logo" 
                class="mx-auto h-24 w-24 sm:h-32 sm:w-32 object-contain mb-4"
                onerror="console.error('Logo image failed to load')"
            >
        </div>

        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-2 bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
            Create Account
        </h2>
        <p class="text-center text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">Register to the system.</p>

        <x-validation-errors class="mb-4" />

        <form wire:submit="register">
            <!-- Personal Information Section -->
            <div class="mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Personal Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <x-label for="first_name" value="{{ __('First Name') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                        <x-input 
                            id="first_name" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" 
                            type="text" 
                            wire:model="first_name"
                            required 
                            autofocus 
                            autocomplete="given-name" 
                        />
                        @error('first_name') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-label for="middle_name" value="{{ __('Middle Name') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                        <x-input 
                            id="middle_name" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" 
                            type="text" 
                            wire:model="middle_name"
                            autocomplete="additional-name" 
                        />
                        @error('middle_name') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-label for="last_name" value="{{ __('Last Name') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                        <x-input 
                            id="last_name" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" 
                            type="text" 
                            wire:model="last_name"
                            required 
                            autocomplete="family-name" 
                        />
                        @error('last_name') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Student Information Section -->
            <div class="mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Student Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <x-label for="student_id" value="{{ __('Student ID') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                        <x-input 
                            id="student_id" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" 
                            type="text" 
                            wire:model="student_id"
                            autocomplete="off" 
                        />
                        @error('student_id') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="grade_level" value="{{ __('Grade Level (SHS)') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                            <select 
                                id="grade_level" 
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm sm:text-base"
                                wire:model="grade_level"
                            >
                                <option value="">Select Grade Level</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                            @error('grade_level') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-label for="year_level" value="{{ __('Year Level (College)') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                            <select 
                                id="year_level" 
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm sm:text-base"
                                wire:model="year_level"
                            >
                                <option value="">Select Year Level</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                                <option value="5">5th Year</option>
                            </select>
                            @error('year_level') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="shs_strand" value="{{ __('SHS Strand') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                            <select 
                                id="shs_strand" 
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm sm:text-base {{ $year_level ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                wire:model="shs_strand"
                                {{ $year_level ? 'disabled' : '' }}
                            >
                                <option value="">Select SHS Strand</option>
                                <option value="ABM">ABM</option>
                                <option value="HUMSS">HUMSS</option>
                                <option value="GAS">GAS</option>
                                <option value="ICT">ICT</option>
                            </select>
                            @error('shs_strand') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-label for="college_program" value="{{ __('College Program') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                            <select 
                                id="college_program" 
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm sm:text-base {{ $grade_level ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                wire:model="college_program"
                                {{ $grade_level ? 'disabled' : '' }}
                            >
                                <option value="">Select College Program</option>
                                <option value="BSIT">BSIT</option>
                                <option value="BSBA">BSBA</option>
                            </select>
                            @error('college_program') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information Section -->
            <div class="mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Account Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                        <x-input 
                            id="email" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" 
                            type="email" 
                            wire:model="email"
                            required 
                            autocomplete="username" 
                        />
                        @error('email') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                            <x-input 
                                id="password" 
                                class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" 
                                type="password" 
                                wire:model="password"
                                required 
                                autocomplete="new-password" 
                            />
                            @error('password') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-gray-700 font-medium text-sm sm:text-base" />
                            <x-input 
                                id="password_confirmation" 
                                class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base" 
                                type="password" 
                                wire:model="password_confirmation"
                                required 
                                autocomplete="new-password" 
                            />
                            @error('password_confirmation') <span class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <label for="terms" class="flex items-start">
                        <x-checkbox name="terms" id="terms" wire:model="terms" required />
                        <div class="ms-2 text-xs sm:text-sm">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-blue-600 hover:text-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-blue-600 hover:text-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </label>
                    @error('terms') <span class="text-red-600 text-xs sm:text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-end mt-6 gap-3">
                <a class="underline text-xs sm:text-sm text-blue-600 hover:text-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 border border-transparent rounded-lg font-semibold text-xs sm:text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-150 shadow hover:shadow-lg">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>