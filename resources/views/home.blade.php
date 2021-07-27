<!DOCTYPE html>

<html lang="en" class="append-scoll">
<head>
    <title>Mailer Lite - Subscription Management</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>--}}
</head>
<body class="append-scoll">
<container class="landing-page mobile">
    <section class="general-info-section">
        <p class="h1">Want quick access to your <br/>mailerlite subscribers ?</p>
        <p class="h2">Well, you came to the right place!<br/></p>
        <p class="h3">Why choose us ?</p>
        <p class="text">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
        <section class="sign-up-section">
            <input type="password" placeholder="Enter you mailer lite API-KEY" id="key"/>
            <button type="button" onclick="authenticate()" class="">START MANAGING SUBSCRIBERS</button>
        </section>
    </section>
    <section class="image-review-section hidden">
    </section>
</container>

</body>

</html>

<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Overpass&display=swap');

    html,body{
        width: 100%;
        height: 100%;
        padding: 0px;
        margin: 0px;
        overflow: hidden!important;
        overflow-y: hidden!important;
        overflow-x: hidden!important;
    }

    .landing-page{
        margin: 0px!important;
        color: #fff;
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        align-items:center;
        width: 100%;
        height: 100%;
        background: rgb(40,176,51);
        background: linear-gradient(81deg, rgba(40,176,51,1) 0%, rgba(32,116,42,1) 100%);
        overflow: hidden!important;
        overflow-y: hidden!important;
        overflow-x: hidden!important;
    }

    .general-info-section,.image-review-section{
        width: 40%;
        margin: 5em;
    }

    .image-review-section{
        width: 30%;
    }

    .sign-up-section{
        width: 100%;
        display: flex;
        flex-flow: row wrap;
        font-family: 'Overpass', sans-serif;
    }

    .sign-up-section input, .sign-up-section button{
        padding:1em;
        outline: none;
        border: none;

    }

    .sign-up-section input{
        width: 55%;
    }

    .sign-up-section button{
        cursor: pointer;
        background-color: #000;
        color: white;
        font-weight: bolder;
    }

    .sign-up-section button:hover{
        background-color: rgb(57, 57, 57);
    }

    .image-review-section{
        background-image: url('https://images.pexels.com/photos/669619/pexels-photo-669619.jpeg?cs=srgb&dl=pexels-lukas-669619.jpg&fm=jpg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        height: 600px;
        box-shadow: 0px 0px 50px rgba(10,10,10,0.6);
        border-radius: 10px;
    }

    .h1{
        font-family: 'Archivo Black', sans-serif;
        font-size: 2.5vw;
    }

    .h2 {
        font-family: 'Overpass', sans-serif;
        font-size: 2vw;
    }

    .h3 {
        font-family: 'Overpass', sans-serif;
        font-size: 1.5vw;
    }

    .text{
        font-family: 'Overpass', sans-serif;
    }

    .pa-0{
        padding: 0px;
    }

    .pa-1{
        padding: 0.1em;
    }

    @media only screen and (max-width: 1068px) {
        [class*="append-scoll"] {
            overflow: visible!important;
            overflow-y: visible!important;
            overflow-x: visible!important;
        }



        [class*="hidden"] {
            display: none !important;
        }

        .sign-up-section input, .sign-up-section button{
            width: 100%;
            margin: 0.5em;
        }

        .general-info-section{
            width: 80%;
        }
    }
</style>

<script type="text/javascript">

    const isAuthenticated = localStorage.getItem('authenticated');

    if(isAuthenticated){
        location.href = "/dash";
    }else{
        gsap.timeline()
            .from('.landing-page',{opacity: 0, duration: 0.8, scale: 0,ease: "back"})
            .from('.general-info-section p', {opacity: 0, yPercent:-100, stagger: 0.2, duration: 0.8, delay: 1, ease: "back"})
            .from('.sign-up-section', {opacity: 0, y: -30, duration:1,delay: 0.5, ease: "back"})
            .from('.image-review-section', {opacity: 0, y: 300, duration:1,delay: 0.5, ease: "back"});
    }

    async function authenticate(){
        const user = +new Date();

        let apikey = document.getElementById('key').value;
        if(!apikey){
            alert('Please enter a valid apu key.');
            return;
        }
        let request = {
            user: user.toString(),
            token: apikey
        }

        let response = await fetch('api/user/auth', {
            method: 'POST',
            body: JSON.stringify(request)
        });

        let data = await response.text();

        if(data){
            localStorage.setItem('user',data);
            localStorage.setItem('authenticated',true);
            location.href = "/dash";
        }
    }
</script>
