<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 via-yellow-50 to-blue-100">
    <div class="w-full sm:max-w-2xl mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-blue-100">
        <div class="mb-6 text-center">
            <x-authentication-card-logo />
        </div>

        <h2 class="text-3xl font-bold text-center mb-2 bg-gradient-to-r from-blue-600 to-yellow-500 bg-clip-text text-transparent">
            Create Account
        </h2>
        <p class="text-center text-gray-600 mb-6">Register to the system.</p>

        <x-validation-errors class="mb-4" />

        <form wire:submit="register">
            <!-- Personal Information Section -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Personal Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <x-label for="first_name" value="{{ __('First Name') }}" class="text-gray-700 font-medium" />
                        <x-input 
                            id="first_name" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                            type="text" 
                            wire:model="first_name"
                            required 
                            autofocus 
                            autocomplete="given-name" 
                        />
                        @error('first_name') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-label for="middle_name" value="{{ __('Middle Name') }}" class="text-gray-700 font-medium" />
                        <x-input 
                            id="middle_name" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                            type="text" 
                            wire:model="middle_name"
                            required 
                            autocomplete="additional-name" 
                        />
                        @error('middle_name') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-label for="last_name" value="{{ __('Last Name') }}" class="text-gray-700 font-medium" />
                        <x-input 
                            id="last_name" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                            type="text" 
                            wire:model="last_name"
                            required 
                            autocomplete="family-name" 
                        />
                        @error('last_name') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Student Information Section -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Student Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <x-label for="student_id" value="{{ __('Student ID') }}" class="text-gray-700 font-medium" />
                        <x-input 
                            id="student_id" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                            type="number" 
                            wire:model="student_id"
                            required 
                            autocomplete="off" 
                        />
                        @error('student_id') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-label for="grade_level" value="{{ __('Grade Level (SHS)') }}" class="text-gray-700 font-medium" />
                            <select 
                                id="grade_level" 
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                wire:model="grade_level"
                            >
                                <option value="">Select Grade Level</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                            @error('grade_level') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-label for="year_level" value="{{ __('Year Level (College)') }}" class="text-gray-700 font-medium" />
                            <select 
                                id="year_level" 
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                wire:model="year_level"
                            >
                                <option value="">Select Year Level</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                                <option value="5">5th Year</option>
                            </select>
                            @error('year_level') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <x-label for="program" value="{{ __('Program/Course') }}" class="text-gray-700 font-medium" />
                        <x-input 
                            id="program" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                            type="text" 
                            wire:model="program"
                            placeholder="e.g., BS Computer Science, STEM"
                            autocomplete="off" 
                        />
                        @error('program') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Account Information Section -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Account Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-medium" />
                        <x-input 
                            id="email" 
                            class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                            type="email" 
                            wire:model="email"
                            required 
                            autocomplete="username" 
                        />
                        @error('email') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium" />
                            <x-input 
                                id="password" 
                                class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                                type="password" 
                                wire:model="password"
                                required 
                                autocomplete="new-password" 
                            />
                            @error('password') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-gray-700 font-medium" />
                            <x-input 
                                id="password_confirmation" 
                                class="block mt-1 w-full border-blue-200 focus:border-blue-500 focus:ring-blue-500" 
                                type="password" 
                                wire:model="password_confirmation"
                                required 
                                autocomplete="new-password" 
                            />
                            @error('password_confirmation') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <label for="terms" class="flex items-start">
                        <x-checkbox name="terms" id="terms" wire:model="terms" required />
                        <div class="ms-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-blue-600 hover:text-yellow-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-blue-600 hover:text-yellow-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </label>
                    @error('terms') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            @endif

            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm text-blue-600 hover:text-yellow-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="ms-4 inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-150 shadow-lg hover:shadow-xl">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>