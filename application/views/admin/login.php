<div class="hs_auth_wrapper">
    <div class="hs_auth_logo">
        <h3>Admin Login</h3>
    </div>
    <div class="hs_auth_inner">
        <div class="hs_input">
            <label>Email address</label>
            <input type="email" class="form-control" placeholder="Email">
        </div>
        <div class="hs_input">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="Password">
        </div>
        <div class="hs_checkbox">
            <input type="checkbox" id="user_remember" checked="">
            <label for="user_remember">Remember Password</label>
        </div>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn">Login</a>
    </div>
</div>