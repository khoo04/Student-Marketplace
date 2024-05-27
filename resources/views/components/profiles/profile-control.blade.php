@props(['user'])

<div class="title-container">
    <h1>My Profile</h1>
</div>
<div class="profile-container">
    <div id="change-information-section" class="form-section">
        <form action="" method="post">
            @method('PUT')
            @csrf
            <label for="fname">First Name</label>
            <input type="text" name="fname" id="fname" value="{{$user->first_name}}">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" value="{{$user->last_name}}">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{$user->email}}">
            <input type="submit" value="Update">
        </form>
    </div>

    <div id="change-password-section" class="form-section">
        <h1>Change Password</h1>
        <form action="" method="post">
            <label for="oldpass">Old Password</label>
            <input type="password" name="oldpass" id="oldpass">
            <label for="newpass">New Password</label>
            <input type="password" name="newpass" id="newpass">
            <input type="submit" value="Update">
        </form>
    </div>
</div>