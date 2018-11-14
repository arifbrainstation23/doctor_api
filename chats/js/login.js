'use strict';

function Login() {
	
    this.isLoginPageRendered = false;
    this.isLogin = false;
}

Login.prototype.init = function(){
    var self = this;

    return new Promise(function(resolve, reject) {
        var user = localStorage.getItem('user');
        if(user && !app.user){
            var savedUser = JSON.parse(user);
            app.room = savedUser.tag_list;
            self.login(savedUser)
                .then(function(){
                    resolve(true);
                }).catch(function(error){
                reject(error);
            });
        } else {
            resolve(false);
        }
    });
};

Login.prototype.login = function (user) {
    var self = this;
    return new Promise(function(resolve, reject) {
        if(self.isLoginPageRendered){
            document.forms.loginForm.login_submit.innerText = 'loading...';
        } else {
            self.renderLoadingPage();
        }
       

// var userMan = {
//       id: 35547586,
//       name: 'rudra',
//       login: 'rudratosh',
//       pass: 'Roshni@1'
//     };
 
// QB.createSession({login: userMan.login, password: userMan.pass}, function(err, res) {
//   if (res) {
   
//     QB.chat.connect({userId: userMan.id, password: userMan.pass}, function(err, roster) {
//       if (err) {
//           console.log(err);
         
//       } else {
 
//     loginSuccess(userMan);
 
//       }
//     });
//   }else{
//     console.log(err);
        
//   }
// });
        QB.createSession(function(csErr, csRes) {
            
            // var userMan = {
            //       id: 4448514,
            //       name: 'rudratosh',
            //       login: 'rudratosh',
            //       pass: 'Roshni@1'
            //     };
            var userRequiredParams = {
                'login':user.login,
                'password': user.password
            };
            if (csErr) {
                loginError(csErr);
            } else {
                app.token = csRes.token;
                QB.login(userRequiredParams, function(loginErr, loginUser){
                     
                    if(loginErr) {
                        /** Login failed, trying to create account */
                        QB.users.create(user, function (createErr, createUser) {
                            if (createErr) {
                                loginError(createErr);
                            } else {
                                QB.login(userRequiredParams, function (reloginErr, reloginUser) {
                                    if (reloginErr) {
                                        loginError(reloginErr);
                                    } else {
                                        loginSuccess(reloginUser);
                                    }
                                });
                            }
                        });
                    } else {
                        /** Update info */
                        if(loginUser.user_tags !== user.tag_list || loginUser.full_name !== user.full_name) {
                            QB.users.update(loginUser.id, {
                                'full_name': user.full_name,
                                'tag_list': user.tag_list
                            }, function(updateError, updateUser) {
                                if(updateError) {
                                    loginError(updateError);
                                } else {
                                    loginSuccess(updateUser);
                                }
                            });
                        } else {
                            loginSuccess(loginUser);
                        }
                    }
                });
            }
        });

        function loginSuccess(userData){
            app.user = userModule.addToCache(userData);
            app.user.user_tags = userData.user_tags;
            QB.chat.connect({userId: app.user.id, password: user.password}, function(err, roster){
                if (err) {
                    document.querySelector('.j-login__button').innerText = 'Login';
                    console.error(err);
                    reject(err);
                } else {
                    console.log('roster start');
                    console.log(roster);
                    self.isLogin = true;
                    resolve();
                }
            });
        }

        function loginError(error){
            self.renderLoginPage();
            console.error(error);
           // alert(error + "\n" + error.detail);
            //reject(error);
        }
    });
};

Login.prototype.renderLoginPage = function(){
    console.log('first login');
    helpers.clearView(app.page);

    app.page.innerHTML = helpers.fillTemplate('tpl_login', {
        version: QB.version
    });
    this.isLoginPageRendered = true;
    this.setListeners();

    if(loginForm.hasAttribute('disabled')){
            return false;
        } else {
            loginForm.setAttribute('disabled', true);
        }

        var userName ='',
            userGroup = '';

        // custom code     
       /* var userX = localStorage.getItem('userData');
        var custom_user =  JSON.parse(userX);
        var custom_uname = custom_user.fullname;
        var custom_group = 'doctor';
        var loginName = custom_user.email;
        userName = custom_uname;
        userGroup = custom_group;*/
		
         var userName=localStorage.getItem('user_name');
         var loginName=localStorage.getItem('user_email');
		 
         if(userName =='')
        {
            userName= 'demo';
        }
        var user = {
            login: loginName,
            password: '12345678',
            full_name: userName,
            tag_list: 'user'
        };
		

        localStorage.setItem('user', JSON.stringify(user));
         router.navigate('/dialog/create');
        /*self.login(user).then(function(){
            router.navigate('/dashboard');
        }).catch(function(error){
            alert('lOGIN ERROR\n open console to get more info');
            loginBtn.removeAttribute('disabled');
            console.error(error);
            loginForm.login_submit.innerText = 'LOGIN';
        });*/
};

Login.prototype.renderLoadingPage = function(){
    console.log('first login2');
    helpers.clearView(app.page);
    app.page.innerHTML = helpers.fillTemplate('tpl_loading');
};

Login.prototype.setListeners = function(){
    var self = this,
        loginForm = document.forms.loginForm,
        formInputs = [loginForm.userName, loginForm.userGroup],
        loginBtn = loginForm.login_submit;

    loginForm.addEventListener('submit', function(e){
        e.preventDefault();

        if(loginForm.hasAttribute('disabled')){
            return false;
        } else {
            loginForm.setAttribute('disabled', true);
        }

        var userName = loginForm.userName.value.trim(),
            userGroup = loginForm.userGroup.value.trim();

        // custom code     
        var userX = localStorage.getItem('userData');
        var custom_user =  JSON.parse(userX);
        var custom_uname = custom_user.fullname;
        var custom_group = 'doctor';
        var loginName = custom_user.email;
        userName = custom_uname;
        userGroup = custom_group;

        if(userName =='')
        {
            userName= 'demo';
        }
        var user = {
            login: loginName,
            password: '12345678',
            full_name: userName,
            tag_list: 'user'
        };

        localStorage.setItem('user', JSON.stringify(user));

        self.login(user).then(function(){
            router.navigate('/dashboard');
        }).catch(function(error){
            alert('lOGIN ERROR\n open console to get more info');
            loginBtn.removeAttribute('disabled');
            console.error(error);
            loginForm.login_submit.innerText = 'LOGIN';
        });
    });

    // add event listeners for each input;
    // _.each(formInputs, function(i){
    //     i.addEventListener('focus', function(e){
    //         var elem = e.currentTarget,
    //             container = elem.parentElement;

    //         if (!container.classList.contains('filled')) {
    //             container.classList.add('filled');
    //         }
    //     });

    //     i.addEventListener('focusout', function(e){
    //         var elem = e.currentTarget,
    //             container = elem.parentElement;

    //         if (!elem.value.length && container.classList.contains('filled')) {
    //             container.classList.remove('filled');
    //         }
    //     });

    //     i.addEventListener('input', function(){
    //         var userName = loginForm.userName.value.trim(),
    //             userGroup = loginForm.userGroup.value.trim();
    //         if(userName.length >=3 && userGroup.length >= 3){
    //             loginBtn.removeAttribute('disabled');
    //         } else {
    //             loginBtn.setAttribute('disabled', true);
    //         }
    //     })
    // });
};

var loginModule = new Login();
