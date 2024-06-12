@props(['user'])

<div class="title-container">
    <h1>My Profile</h1>
</div>
<div class="profile-container">
    <div id="change-information-section" class="form-section">
        <form action="{{route('user.updateDetails')}}" method="post">
            @method('PUT')
            @csrf
            <label for="fname">First Name</label>
            <input type="text" name="first_name" id="fname" value="{{$user->first_name}}">
            @error('first_name')
                <p class="form-error-message">{{ $message }}</p>
            @enderror
            <label for="lname">Last Name</label>
            <input type="text" name="last_name" id="lname" value="{{$user->last_name}}">
            @error('last_name')
                <p class="form-error-message">{{ $message }}</p>
            @enderror
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{$user->email}}">
            @error('email')
                <p class="form-error-message">{{ $message }}</p>
            @enderror
            <input type="submit" value="Update">
        </form>
    </div>

    <div id="change-password-section" class="form-section">
        <h1>Change Password</h1>
        <form action="{{route('user.updatePassword')}}" method="post">
            @method('PUT')
            @csrf
            <label for="oldpass">Old Password</label>
            <div class="input-box">
                <input type="password" name="old_password" id="oldpass">
                <i class="fa-solid fa-eye-slash"></i>
            </div>
            @error('old_password')
                <p class="form-error-message">{{ $message }}</p>
            @enderror
            <label for="newpass">New Password</label>
            <div class="input-box">
                <input type="password" name="new_password" id="newpass">
                <i class="fa-solid fa-eye-slash"></i>
            </div>
            @error('new_password')
                <p class="form-error-message">{{ $message }}</p>
            @enderror
            <input type="submit" value="Update">
        </form>
    </div>
</div>

<style>
.input-box {
    position: relative;
    display: inline-block;
    width: 100%;
}

.input-box input {
    width: 100%;
    padding-right: 30px; /* Adjust this based on icon size */
}

.input-box i {
    position: absolute;
    top: 35%;
    right: 10px; /* Adjust this based on padding and icon size */
    transform: translateY(-50%);
    cursor: pointer;
}
</style>

@section('js')
<script>
    $(document).ready(function () {
        $("input").on("focus", function () {
            $(this).parent().addClass("focused");
        })

        $("input").on("blur", function () {
            $(this).parent().removeClass("focused");
        })

        $(".input-box i").on("mousedown", function (event) {
            event.preventDefault();
            event.stopPropagation();
        })
            .on("click", function () {
                let passwordInput = $(this).prev("input");
                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text");
                    $(this).removeClass("fa-eye-slash").addClass("fa-eye");
                } else {
                    passwordInput.attr("type", "password");
                    $(this).removeClass("fa-eye").addClass("fa-eye-slash");
                }
            });
    });
</script>
@endsection