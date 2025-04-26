<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">

    <title>إنشاء حساب</title>
    <link rel="stylesheet" href="bootstrap.min.css">
   
    <style>

        body {
            background-color:#076177; /* لون الخلفية */
        }

        .card {
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .strength-meter {
            height: 8px;
            width: 100%;
            background-color: #ddd;
            margin-top: 5px;
            border-radius: 4px;
        }

        .strength-meter div {
            height: 100%;
            border-radius: 4px;
        }

        .weak { width: 33%; background-color: red; }
        .medium { width: 66%; background-color: orange; }
        .strong { width: 100%; background-color: green; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2 class="text-info text-center mt-3">إنشاء حساب</h2>
            <form action="" method="post" enctype="multipart/form-data" id="signupForm" class="text-center">
                
               
                <div class="mb-3">
                    <label class="form-label">ادخل الاسم</label>
                    <input type="text" name="name" id="full_name" class="form-control border border-primary">
                    <p class="welcome text-info d-none" id="welcome">أهلا وسهلا ومرحبا صديقنا العزيز "<span id="demo" class="text-success"></span>"</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">اختيار الفئة</label>
                    <select name="quran_cate" id="quran_cate">
                        <option value="30">القرأن كاملا</option>
                        <option value="20">فئة العشرين جزء </option>
                        <option value="15">فئة خمس عشر جزء</option>
                        <option value="10">فئة عشر اجزاء</option>
                        
                    </select>
                    </div>
     
                <div class="mb-3">
                    <label class="form-label">ادخل كلمة السر</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" class="form-control">
                        <span class="toggle-password" onclick="togglePassword('password')"></span>
                    </div>
             
                    <div class="strength-meter"><div id="strength-bar"></div></div>
                    <small id="strength-text"></small>
                </div>

             
                <div class="mb-3">
                    <label class="form-label">تأكيد كلمة السر</label>
                    <div class="password-container">
                        <input type="password" name="rpassword" id="rpassword" class="form-control">
                        <span class="toggle-password" onclick="togglePassword('rpassword')"></span>
                    </div>
                    <div class="invalid-feedback">كلمة السر غير متطابقة</div>
                    <div class="valid-feedback">كلمة السر متطابقة</div>
                </div>

                <input type="submit" value="إرسال" class="btn btn-primary w-100">
            </form>
        </div>
    </div>

    <!
    <script src="bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('full_name').addEventListener('input', function() {
            const text = document.getElementById('demo');
            const para = document.getElementById('welcome');
            if (this.value !== "") {
                text.innerHTML = this.value;
                para.classList.remove('d-none');
            } else {
                para.classList.add('d-none');
            }
        });

        
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = (input.type === "password") ? "text" : "password";
        }

        document.getElementById('rpassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            if (this.value !== password) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });

       
        document.getElementById('password').addEventListener('input', function() {
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            const password = this.value;
            
            let strength = 0;
            if (password.length >= 8) strength++; 
            if (/[A-Z]/.test(password)) strength++; 
            if (/[a-z]/.test(password)) strength++; 
            if (/\d/.test(password)) strength++; 
            if (/[\W]/.test(password)) strength++; 
            strengthBar.className = "";
            if (strength <= 2) {
                strengthBar.classList.add("weak");
                strengthText.innerText = "كلمة المرور ضعيفة";
                strengthText.style.color = "red";
            } else if (strength <= 4) {
                strengthBar.classList.add("medium");
                strengthText.innerText = "كلمة المرور متوسطة";
                strengthText.style.color = "blue";
            } else {
                strengthBar.classList.add("strong");
                strengthText.innerText = "كلمة المرور قوية";
                strengthText.style.color = "green";
            }
        });
    </script>
</body>
</html>