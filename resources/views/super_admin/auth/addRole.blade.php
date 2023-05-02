<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{url('/superadmin/addNewRole')}}">
            @csrf

            <!--Role -->
            <div>
                <x-label for="name" :value="__('Role')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Permission -->
            <div class="form-group">
                                <label><strong>Permision :</strong></label><br>
                                @foreach($permission as $user)
                                <label><input type="checkbox" name="permission[]" value="{{$user->id}}">{{$user->name }}</label>
                                @endforeach
                            </div>  
            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
