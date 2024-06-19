@props(['user'])

<div class="title-container">
    <h1>My Profile</h1>
</div>
<div class="profile-container">
    <div id="change-information-section" class="form-section">
        <form action="{{ route('user.updateDetails') }}" method="post">
            @method('PUT')
            @csrf
            <div class="profile-form-field">
                <label for="fname">First Name</label>
                <div class="input-box">
                    <input type="text" name="first_name" id="fname" value="{{ $user->first_name }}">
                </div>
                @error('first_name')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="profile-form-field">
                <label for="lname">Last Name</label>
                <div class="input-box">
                    <input type="text" name="last_name" id="lname" value="{{ $user->last_name }}">
                </div>
                @error('last_name')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="profile-form-field">
                <label for="email">Email</label>
                <div class="input-box">
                    <input type="email" name="email" id="email" value="{{ $user->email }}">
                </div>
                @error('email')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <input type="submit" value="Update">
        </form>
    </div>

    <div id="change-password-section" class="form-section">
        <h1>Change Password</h1>
        <form action="{{ route('user.updatePassword') }}" method="post">
            @method('PUT')
            @csrf
            <div class="profile-form-field">
                <label for="oldpass">Old Password</label>
                <div class="input-box">
                    <input type="password" name="old_password" id="oldpass">
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
                @error('old_password')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="profile-form-field">
                <label for="newpass">New Password</label>
                <div class="input-box">
                    <input type="password" name="new_password" id="newpass">
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
                @error('new_password')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <input type="submit" value="Update">
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {
        $(".input-box > input").on("focus", function() {
            $(this).parent().addClass("focused");
        })

        $(".input-box > input").on("blur", function() {
            $(this).parent().removeClass("focused");
        })

        $(".input-box i").on("mousedown", function(event) {
                event.preventDefault();
                event.stopPropagation();
            })
            .on("click", function() {
                let passwordInput = $(this).prev("input");
                let inputValue = passwordInput.val();
                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text");
                    $(this).removeClass("fa-eye-slash").addClass("fa-eye");
                } else {
                    passwordInput.attr("type", "password");
                    $(this).removeClass("fa-eye").addClass("fa-eye-slash");
                }
                setTimeout(function() {
                    passwordInput.focus();
                    passwordInput[0].setSelectionRange(inputValue.length, inputValue.length);
                }, 0);
            });
    });
</script>
