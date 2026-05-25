@section('title', 'Dashboard') 
@include('backend.includes.head')
<style>
.badge-blinking  {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {  
  50% { opacity: 0; }
}
</style>
<body scroll-spy="" id="top" class=" theme-template-dark theme-pink alert-open alert-with-mat-grow-top-right">
<style>
.modal-dialog {
  padding-top:10%;
}
.modal-backdrop {
    
}
.preview-table >tbody>tr>th,.preview-table >tbody>tr>td{
  padding-top: 4px;
    padding-bottom: 3px;
    color: black !important;
    font-weight: unset;
    font-size: 15px !important;
  border:1px #d6d0d0 solid;
}
.preview-table>tbody>tr>th{
  width:33%;
  text-transform:none;
}
.selected_row{
  background: #90CAF9;
    color: white;
}
</style>
<link href='{{url("public/asserts/css/main.css")}}' rel='stylesheet' />

<script src='{{url("public/asserts/js/main.js")}}'></script>

  <main>
  @include('backend.includes.sidebar')
     <div class="main-container">
    @include('backend.includes.header')
  <div class="main-content" autoscroll="true" bs-affix-target="" init-ripples="" style="padding-top:0px">
          <section>
          
              <br>
          </section>
        </div>

   </div>
    </main>
    <style>
    .glyphicon-spin-jcs {
      -webkit-animation: spin 1000ms infinite linear;
      animation: spin 1000ms infinite linear;
    }
    
    @-webkit-keyframes spin {
      0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
      }
    }
    
    @keyframes spin {
      0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
      }
    }
    </style>
    
    <script>
    (function(i, s, o, g, r, a, m)
    {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function()
      {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o), m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-62479268-1', 'auto');
    ga('send', 'pageview');
  
    </script>
    
  <script charset="utf-8" src="{{url('public/asserts/js/vendors.min.js')}}"></script>
    <script charset="utf-8" src="{{url('public/asserts/js/app.min.js')}} "></script>
  </body>
</html>


@include('backend.includes.footer')
