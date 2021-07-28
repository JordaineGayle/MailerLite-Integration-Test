<html>

    <head>
        <title>Mailer Lite Subscription Dashboard</title>
{{--        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">--}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.semanticui.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/dataTables.semanticui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
    </head>

    <body>
        <nav class="nav-bar">
            <header style="padding-left: 1em;">
                <h4><a style="color: white" href="/dash">MLite Dashboard</a></h4>
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

        {{-- DATATABLES Section --}}
        <div class="table-container">
            <section class="table-section">
                <table id="mlite-data-table" class="ui celled table" style="width: 100%; height: 400px!important; overflow-y: scroll;">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Subscribe Date</th>
                        <th>Subscribe Time</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Subscribe Date</th>
                        <th>Subscribe Time</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </section>
        </div>

        {{--Edit Subscriber Modal--}}
        <div class="ui modal tiny">
            <i class="close icon"></i>
            <div class="header">
                Edit Subscriber
            </div>
            <form class="ui form" action="#">
                <div class="field">
                    <label>First Name</label>
                    <input type="text" name="Name" placeholder="Name">
                </div>
                <div class="field">
                    <label>Last Name</label>
                    <input type="text" name="Country" placeholder="Country">
                </div>
                <button class="inverted ui green button" type="button" onclick="editSubscriber()">Save</button>
            </form>
            <div class="ui negative message" style="display: none;">
                <i class="close icon"></i>
                <div class="header">
                    Edit subscriber failed.
                </div>
                <p>There was an error editing that subscriber. Please contact admin or try again later.</p>
            </div>
        </div>
    </body>
</html>

<style>
    /*@import url('https://fonts.googleapis.com/css2?family=Overpass&display=swap');*/

    html,body{
        padding: 0px;
        margin: 0px;
        /*font-family: 'Overpass', sans-serif;*/
        font-family: Verdana;
    }

    .nav-bar{
        width: 100%;
        background: rgb(40,176,51);
        background: linear-gradient(81deg, rgba(40,176,51,1) 0%, rgba(32,116,42,1) 100%);
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        /*position: fixed;*/
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

    /*.nav-bar ul li:last-child{*/
    /*    background-color: #212121;*/
    /*    border-radius: 10px;*/
    /*}*/

    /*.nav-bar ul li:last-child:hover{*/
    /*    background-color: rgba(50,50,50,1);*/
    /*    transition: background-color 0.4s;*/
    /*}*/

    .form{
        padding: 2em;
    }

    .table-container{
        margin-left: auto;
        margin-right: auto;
        width: 1200px;
        height: 400px;
        display: flex;
        justify-content: center;
        padding: 2em;
    }
    .table-section{
        width: 100%;
        padding: 2em;
        height: 400px;
    }
</style>

<script>

    const isAuthenticated = localStorage.getItem('authenticated');

    let currentData = {};

    let tblInstance = null;

    if(!isAuthenticated){
        location.href = "/";
    }

    function resetToken(){
        localStorage.clear();
        location.href = "/";
    }

    $(document).ready(function() {

        var table = $('#mlite-data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                'url': "api/subscribers",
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("user", localStorage.getItem('user'));
                }

            },
            "columns": [
                { "data": "email" },
                { "data": "name" },
                { "data": "country" },
                { "data": "date_subscribed" },
                { "data": "time_subscribed" },
                // { "data": "id" }
            ],
            "columnDefs": [ {
                "targets": 5,
                "data": null,
                "defaultContent": "<button class='ui inverted red button'>Delete</button>"
            } ]
        });

        tblInstance = table;


        $('#mlite-data-table tbody').on('click', 'button', async function () {
            var data = table.row($(this).parents('tr')).data();
            data.type = "unsubscribed";
            $.ajax({
                url: "api/subscribers/unsubscribe",
                data: data,
                type: "POST",
                beforeSend: function(xhr){xhr.setRequestHeader('user', localStorage.getItem('user'));},
                success: function() {
                    table.ajax.reload();
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        $('#mlite-data-table tbody').on('click', 'td:nth-child(1)', async function () {
            var data = table.row($(this).parents('tr')).data();
            $('.tiny.modal').modal('show');
            document.getElementsByName('Name')[0].value = data.name;
            document.getElementsByName('Country')[0].value = data.country;
            currentData = data;
        });

    } );

    async function editSubscriber(){
        currentData.name = document.getElementsByName('Name')[0].value;
        currentData.country = document.getElementsByName('Country')[0].value;

        $.ajax({
            url: "api/subscribers/updateSubscriber",
            data: currentData,
            type: "POST",
            beforeSend: function(xhr){xhr.setRequestHeader('user', localStorage.getItem('user'));},
            success: function() {
                currentData = null;
                tblInstance.ajax.reload();
                $('.tiny.modal').modal('hide');
            },
            error: function (data) {
                $('.negative').show();
                $('.message .close')
                .on('click', function() {
                    $(this)
                        .closest('.message')
                        .transition('fade')
                    ;
                });
            }
        });
    }

    function addSub(){
        location.href = '/new-subscriber'
    }

</script>
