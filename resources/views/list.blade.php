<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel - ToDo List Application</title>
    {{-- CSS --}}
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{-- Font awesome --}}
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/list') }}">ToDo List</a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">Laravel - ToDo List (Click on Each Item to Update or Delete)<a href="#" class="pull-right" data-toggle="modal" data-target="#myModal" id="addNew"><i class="fa fa-plus" aria-hidden="true"></i></a></h3>
				  </div>
				  <div class="panel-body" id="items">
				    @if(count($items)>0)
                        <ul class="list-group">
                            @foreach($items as $item)
                                <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">
                                    <?php if($item->status==1){$status = "checked";}else{$status = "";}?>
                                    <input type="checkbox" name="status" id="statusId" value="{{$item->id}}" <?php echo $status;?>>{{$item->item}}<input type="hidden" id="itemId" value="{{$item->id}}"><br />
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No item found !</p>
                    @endif  
                    Total Items : <?php echo count($items);?><br/>
                    Completed Items : <?php echo $completed;?><br/>
                    Pending Items : <?php echo $pending;?>
				  </div>
				</div>
			</div>

            <div class="col-lg-2">
                <input type="text" name="searchItem" id="searchItem" class="form-control" placeholder="Search">
            </div>

            <!-- modal -->
            <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document"><!-- modal-dialog -->
                    <div class="modal-content"><!-- modal-content -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="title">Add new item</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id">
                            <p><input type="text" id="addItem" placeholder="Enter Values (Max 100 Char) ..." class="form-control"></p>
                            <p>Select Check to Complete this item<input type="checkbox" id="setItem" class="form-control"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal" style="display:none;" id="delete">Delete</button>
                            <button type="button" class="btn btn-primary" style="display:none;" data-dismiss="modal" id="update">Update</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id="add">Add item</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    </div>
    {{ csrf_field() }}
    {{-- script jquery --}}
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    {{-- script bootstrap --}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>    
    {{-- My script --}}
    <script>
        $(document).ready(function(){
                       
            $(document).on('click', '.ourItem', function(event) {
                var text = $(this).text();
                var id = $(this).find('#itemId').val();
                var sid = $('input:checkbox[value="' + id + '"]').prop('checked');                           
                $('#title').text('Edit item');
                var text = $.trim(text);
                $('#add').hide();
                $('#delete').show();
                $('#update').show();
                $('#addItem').val(text);
                if(sid === true){
                    $('#setItem').prop('checked', true);
                }else{
                    $('#setItem').prop('checked', false);
                }
                $('#id').val(id);
                $('#setItem').val(id);
                console.log(text);
            });

            $(document).on('click', '#addNew', function(event) {
                $('#title').text('Add new item');
                $('#add').show();
                $('#delete').hide();
                $('#update').hide();
                $('#addItem').val("");
            });
            
            $('input').on('keypress', function (event) {
                var regex = new RegExp("^[a-zA-Z0-9-,_]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                event.preventDefault();
                return false;
                }
            });

            $('#add').click(function(){
                var text = $('#addItem').val();
                var len = text.length;
                if (len > 100) {
                    alert('100 Characters only allowed');
                    return false;
                }
                var sid = $('#setItem').prop('checked'); 
                if(sid === true){
                    status = 1;
                }else{
                    status = 0;
                }
                if(text == "") {
                    alert('please type anything for item');
                } else { 
                    $.post('create', {'text': text,'status': status,'_token':$('input[name=_token]').val()}, function(data) {
                        //console.log(data);
                        $('#items').load(location.href + ' #items')
                    });
                }
            });

            $('#delete').click(function(){
                var x = confirm("Are you sure you want to delete?");
                if(x) {
                    var id = $("#id").val();
                    $.post('delete', {'id': id,'_token':$('input[name=_token]').val()}, function(data) {
                        $('#items').load(location.href + ' #items');
                        console.log(data);
                    });
                }        
            }); 

            $('#update').click(function(){
                var id = $("#id").val();                
                //$('#setItem').attr(id, 'setItem'+id);
                //alert(id);
                var value = $('#addItem').val();
                var len = value.length;
                if (len > 100) {
                    alert('100 Characters only allowed');
                    return false;
                }
                var sid = $('#setItem').prop('checked'); 
                if(sid === true){
                    status = 1;
                }else{
                    status = 0;
                }
                if(value == "") {
                    alert('please type anything for item');
                } else { 
                    $.post('update', {'id': id, 'value' : value,'status' : status,'_token':$('input[name=_token]').val()}, function(data) {
                        $('#items').load(location.href + ' #items');
                        console.log(data);
                    });
                }    
            });

            $( function() {
            
                $( "#searchItem" ).autocomplete({
                    source: 'http://localhost/todo/public/search'
                });
            }); 
            
        });
    </script>
</body>
</html>
