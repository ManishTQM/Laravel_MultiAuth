<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('super_admin.superadminRegister') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>
            <div class="mt-4">
              <label for="rid" class="form-label">Chose Role</label>
                <select name="rid" id="rid" class="form-control">
                    <option value="-1" disabled selected>--Choose Role--</option>
                    <?php
                    foreach ($role as $roles) {
                        echo "<option value='$roles->id' >$roles->name</option>";
                    } ?>
                </select>

                <label><strong>Send Email :</strong></label><br>
                                @foreach($mail as $user)
                               
                                <label><input type="checkbox" onclick="return ValidateSelection();" name="mailseting" value="{{$user->mail_mailer}}">{{$user->mail_mailer}}</label>
                                @endforeach
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

<script type="text/javascript">  
function ValidateSelection()  
{  
var checkboxes = document.getElementsByName("mailseting");  
var numberOfCheckedItems = 0;  
for(var i = 0; i < checkboxes.length; i++)  
{  
    if(checkboxes[i].checked)  
        numberOfCheckedItems++;  
}  
if(numberOfCheckedItems > 1)  
{  
    alert("You can't select more than one ");  
    return false;  
}  
// function myFunction() {
//   document.getElementById("myCheck").disabled = true;
// }
} 



</script>