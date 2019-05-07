<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Homework pro writers</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <meta name="description" content="HomeWorkPro Writers is taking writing to the next level">
  <meta name="keywords" content="Writers,Writing,Clients,Order,Clients,HomeworkPro Writers,Homework writers, HomeworkPro">
  <meta name="author" content="Neverest ltd">

  <link rel="icon" type="image/png" href="{{asset('images/logo2.png')}}" />

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
  <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

  @yield('style')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../../index2.html" class="navbar-brand"><b>Homework</b>PRO</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="{{route('writer.orders.available')}}">Available orders <span class="sr-only">(current)</span></a></li>
            <li><a href="{{route('writer.orders.all')}}">My orders</a></li>
            <li><a href="{{route('writer.payments.info')}}">Payment Information</a></li>
          </ul>
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
            </div>
          </form>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">{{count(\Illuminate\Support\Facades\Auth::user()->unreadNotifications)}}</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have {{count(\Illuminate\Support\Facades\Auth::user()->unreadNotifications)}} notifications</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">

                    @foreach(\Illuminate\Support\Facades\Auth::user()->unreadNotifications as $notification)
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i>{{(isset($notification->data['text']))?$notification->data['text']:""}}
                        </a>
                      </li>

                    @endforeach

                    @if(count(\Illuminate\Support\Facades\Auth::user()->unreadNotifications)>0)
                      <li class="footer"><a href="{{route('writer.mark_all_notification_As_read')}}">Mark All as Read</a></li>
                    @endif
                  </ul>
                </li>

              </ul>
            </li>

            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                <span class="hidden-xs">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  @if(\Illuminate\Support\Facades\Auth::user()->avatar!='')
                  <img src="{{asset('uploads/user_pictures/'. \Illuminate\Support\Facades\Auth::user()->avatar)}}" class="img-circle" alt="User Image">

                  @else

                    <img src="{{asset('dist/img/anonymous.jpg')}}" class="img-circle" alt="User Image">

                  @endif
                  <p>
                   {{\Illuminate\Support\Facades\Auth::user()->name}}
                    <small>Member since {{\Illuminate\Support\Facades\Auth::user()->created_at->toDayDateTimeString()}}</small>
                  </p>
                </li>

                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{route('writer.profile')}}" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>

                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <section class="content-header" style="background: white;padding-bottom: 10px">
      <h1>
        Writers portal
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">writer</a></li>
        <li class="active">@yield('page')</li>
      </ol>
    </section>

    <div class="container-fluid">
      <!-- Content Header (Page header) -->


      <!-- Main content -->
      <section class="content">

        @yield('content')
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>

  <div class="modal " tabindex="-1" role="dialog" id="announcement_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Current Unread Announcements</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="box-body">
            <table class="table table-responsive">
           <thead>
             <tr>
               <th>Title</th>
               <th>New Article</th>
             </tr>
           </thead>
              <tbody>
              <tr v-for="announcement in announcements">
                <td>   @{{ announcement.title }}</td>
                <td v-html=" announcement.news_article ">   @{{ announcement.news_article }}</td>
              </tr>
              </tbody>
            </table>


          </div>


        </div>
        <div class="modal-footer">
          <a href="{{route('writer.change_announcement')}}"  class="btn btn-primary" >Mark As Read</a>
        </div>
      </div>
    </div>
  </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
      </div>
      <strong>Copyright &copy; {{date('Y')}} <a href="https://adminlte.io">Homeworkprowriters</a>.</strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('axios.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>

<script src="{{asset('js/sock.min.js')}}"></script>
<script src="{{asset('js/thunder.js')}}"></script>

<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "e0f5df37-237c-4801-93b8-c1ac464031f9",
    });
  });

  OneSignal.push(function() {
    OneSignal.sendTags({
      user_id: '{{Auth::id()}}'
    }).then(function(tagsSent) {
      // Callback called when tags have finished sending
      console.log(tagsSent);
    });
  });
</script>


@yield('script')
{{--handle the announcements here--}}
<script type="application/javascript">

  let modal_content=new Vue({
    el:'#announcement_modal',
    data:{
      announcements:[],
    },
    created:function(){
      let url='{{route('writer.check_announcements')}}';
      let me=this;
      axios.get(url)
              .then(res=>{
              me.announcements=res.data.announcements;
          console.log('{{session()->get('markedRead')}}');
                if (res.data.announcements.length===0  ){

              }else{
                  if ('{{session()->get('markedRead')}}'==='yes'){

                  } else{
                    //show the modal
                    $('#announcement_modal').modal('show');

                  }
              }
              })
    },
    methods:{


    }
  });

</script>
</body>
</html>
