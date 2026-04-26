 {{-- <div class="flex flex-col gap-6">
     <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

     <!-- Session Status -->
     <x-auth-session-status class="text-center" :status="session('status')" />

     <form wire:submit="register" class="flex flex-col gap-6">
         <!-- Name -->
         <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
             :placeholder="__('Full name')" />

         <!-- Email Address -->
         <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
             placeholder="email@example.com" />

         <!-- Password -->
         <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="new-password"
             :placeholder="__('Password')" viewable />

         <!-- Confirm Password -->
         <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
             autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

         <div class="flex items-center justify-end">
             <flux:button type="submit" variant="primary" class="w-full">
                 {{ __('Create account') }}
             </flux:button>
         </div>
     </form>

     <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
         {{ __('Already have an account?') }}
         <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
     </div>
 </div> --}}
 <div class="flex flex-col gap-6">
     <style>
         .uiverse-container {
             max-width: 350px;
             background: linear-gradient(0deg, #fff 0%, #f4f7fb 100%);
             border-radius: 40px;
             padding: 25px 35px;
             border: 5px solid #fff;
             box-shadow: rgba(133, 189, 215, 0.88) 0px 30px 30px -20px;
             margin: 40px auto;
         }

         .uiverse-heading {
             text-align: center;
             font-weight: 900;
             font-size: 30px;
             color: rgb(16, 137, 211);
         }

         .uiverse-form {
             margin-top: 20px;
         }

         .uiverse-input-wrapper {
             margin-top: 15px;
         }

         .uiverse-login-button {
             font-weight: bold;
             background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
             color: white !important;
             padding-block: 15px;
             margin-top: 25px;
             border-radius: 20px;
             box-shadow: rgba(133, 189, 215, 0.88) 0px 20px 10px -15px;
             border: none;
             transition: all 0.2s ease-in-out;
             width: 100%;
         }

         .uiverse-login-button:hover {
             transform: scale(1.03);
             box-shadow: rgba(133, 189, 215, 0.88) 0px 23px 10px -20px;
         }
     </style>

     <div class="uiverse-container">
         <div class="uiverse-heading">{{ __('Create an account') }}</div>

         <!-- Session Status -->
         <x-auth-session-status class="text-center" :status="session('status')" />

         <form wire:submit="register" class="uiverse-form">
             <!-- Name -->
             <div class="uiverse-input-wrapper">
                <label for="email"
                    style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                    {{ __('Name') }}
                </label>
                 <flux:input wire:model="name" type="text" required autofocus autocomplete="name"
                     :placeholder="__('Full name')"
                     style="width: 100%; background: white; border: none; padding: 15px 20px; border-radius: 20px; box-shadow: #cff0ff 0px 10px 10px -5px; color: rgb(18, 177, 209);" />
             </div>

             <!-- Email -->
             <div class="uiverse-input-wrapper">
                <label for="email"
                    style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                    {{ __('Email address') }}
                </label>
                 <flux:input wire:model="email"  type="email" required
                     autocomplete="email" placeholder="email@example.com"
                     style="width: 100%; background: white; border: none; padding: 15px 20px; border-radius: 20px; box-shadow: #cff0ff 0px 10px 10px -5px; color: rgb(18, 177, 209);" />
             </div>

             <!-- Password -->
             <div class="uiverse-input-wrapper">
                <label for="email"
                    style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                    {{ __('Password') }}
                </label>
                 <flux:input wire:model="password"  type="password" required
                     autocomplete="new-password" :placeholder="__('Password')" viewable
                     style="width: 100%; background: white; border: none; padding: 15px 20px; border-radius: 20px; box-shadow: #cff0ff 0px 10px 10px -5px; color: rgb(18, 177, 209);" />
             </div>

             <!-- Confirm Password -->
             <div class="uiverse-input-wrapper">
                <label for="email"
                    style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                    {{ __('Confirm password') }}
                </label>
                 <flux:input wire:model="password_confirmation"  type="password" required
                     autocomplete="new-password" :placeholder="__('Confirm password')" viewable
                     style="width: 100%; background: white; border: none; padding: 15px 20px; border-radius: 20px; box-shadow: #cff0ff 0px 10px 10px -5px; color: rgb(18, 177, 209);" />
             </div>

             <!-- Submit -->
             <div>
                 <flux:button type="submit" variant="primary" class="uiverse-login-button">
                     {{ __('Create account') }}
                 </flux:button>
             </div>
         </form>

         <div class="text-center text-sm text-zinc-600 dark:text-zinc-400 mt-4">
             {{ __('Already have an account?') }}
             <flux:link :href="route('login')" wire:navigate class="text-zinc-600 hover:underline">
                 {{ __('Log in') }}
             </flux:link>
         </div>
     </div>
 </div>
