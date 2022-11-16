<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>Hi-Code Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">

    

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      html,
body {
  height: 100%;
  /*background-image: url({{asset('assets/erp.jpg')}});*/
  background : linear-gradient(to right,  #69c5d0, #58a8b1);
  
}

body {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
}
.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
  background-color: rgba(53, 53, 53, 0.233);
  border-radius: 8px;
}
.form-signin:hover{
  
  box-shadow: 1px 1px 10px white;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
  background-color: rgba(228, 228, 228, 0.466);
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  margin-top: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  background-color: rgba(228, 228, 228, 0.466);
}
::-webkit-input-placeholder{
	color: white;
}
:-moz-placeholder{
  color: white;
}
.bd-placeholder-img {
  font-size: 1.125rem;
  text-anchor: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}
.btn{
  background-color: rgba(0, 255, 34, 0);
  border: 1px solid rgb(0, 195, 255);
  color: white;
}
.btn:hover{
  background-color: rgb(0, 255, 255) ;
}

@media (min-width: 768px) {
  .bd-placeholder-img-lg {
    font-size: 3.5rem;
  }
}
    </style>

    
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin">
    <img  src="{{asset('assets/erp.png')}}" alt="" width="80%" style="margin-top : -60px">
    
    
<form method="POST" action="{{ route('login') }}">
        @csrf
    <img class="mb-4" src="{{asset('assets/codes.png')}}" alt="" width="80%" style="margin-top : -80px">

    <div class="form-floating" style="margin-top: -80px">
      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="floatingInput" placeholder="name@example.com">
      @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="floatingPassword" placeholder="Password">
      @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      <label for="floatingPassword">Password</label>
    </div>
    <button class="w-100 btn btn-lg " type="submit">Sign in</button>
  </form>
</main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
