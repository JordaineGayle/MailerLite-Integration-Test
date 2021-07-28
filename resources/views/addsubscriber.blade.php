<html>

<head>
    <title>Mailer Lite Subscription Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.semanticui.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
</head>

    <body>
        <nav class="nav-bar">
            <header style="padding-left: 1em;">
                <h4><a style="color: white" href="/dash">Home</a></h4>
            </header>
            <ul>

                <li onclick="addSub()">
                    <button class="ui inverted button">
                        <i class="icon user"></i>
                        Add Subscriber
                    </button>
                </li>
                <li onclick="resetToken()">
                    <button class="ui red button">
                        <i class="icon sync alternate"></i>
                        Reset Token
                    </button>
                </li>
            </ul>
        </nav>

        <section class="form-section">
            <h3>Add Subscriber</h3>
            <form class="ui form" action="#">
                <div class="field">
                    <label>Full Name</label>
                    <input type="text" name="Name" placeholder="Name">
                </div>
                <div class="field">
                    <label>Email Address</label>
                    <input type="text" name="Email" placeholder="Email">
                </div>
                <div class="field">
                    <label>Country</label>
                    <input type="text" name="Country" placeholder="Country">
                </div>
                <button class="inverted ui green button" type="button" onclick="addSubscriber()">Create</button>
            </form>
            <p class="response"></p>
        </section>

    </body>
</html>


<style>
    /*@import url('https://fonts.googleapis.com/css2?family=Overpass&display=swap');*/

    html,body{
        padding: 0px;
        margin: 0px;
        font-family: Verdana;
        height: 100%;
        width: 100%;
    }

    .nav-bar{
        width: 100%;
        background: rgb(40,176,51);
        background: linear-gradient(81deg, rgba(40,176,51,1) 0%, rgba(32,116,42,1) 100%);
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-bar ul{
        list-style: none;
        display: flex;
        flex-flow: row nowrap;
        justify-content: flex-end;
        height: 100%;
        padding-right: 1em;

    }

    .nav-bar ul li{
        padding: 1em;
        cursor: pointer;
        background-color: transparent;
        transition: background-color 0.4s;
    }

    .form-section{
        padding: 2em;
        width: 400px;
        margin-right: 0px;
        margin-left: 0px;
    }

    .form-section h3{
        background-color: #212121;

        color: white;
        padding: 1em;
    }
</style>


<script>
    async function addSubscriber(){

        var name  = document.getElementsByName('Name')[0].value;
        var email = document.getElementsByName('Email')[0].value;
        var country = document.getElementsByName('Country')[0].value;

        if(!email){
            alert("Please set a valid email to subscribe");
            return;
        }

        $.ajax({
            url: "api/subscribers/createSubscriber",
            data: {name: name, email: email, country: country},
            type: "POST",
            beforeSend: function(xhr){xhr.setRequestHeader('user', localStorage.getItem('user'));},
            success: function() {
                document.getElementsByName('Name')[0].value = ''
                document.getElementsByName('Email')[0].value  = ''
                document.getElementsByName('Country')[0].value = ''
                $('.response').html("Successfully Added Subscriber!!!");
            },
            error: function (data) {
                $('.response').html("ERROR: "+data.responseText);
            }
        });
    }
</script>
