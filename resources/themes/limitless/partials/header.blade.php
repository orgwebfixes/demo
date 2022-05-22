<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <span class="border-orange">&nbsp;</span>
    <div class="col-sm-4">
    <div class="navbar-header navbar-header-custom">
            <a class="" href="{{ route('dashboard') }}">
                <img src="{{config('app.url')}}/themes/limitless/images/logo_icon_light.png" alt="">
            </a>
        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
        </ul>
    </div>
    </div>

    @if(!Sentinel::guest())
    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    {{Html::image(AppHelper::path('uploads/user/')->size('36x36')->getImageUrl($current_user->image),'User Photo',array("class"=>"img-circle"))}}
                    <span class='text-capitalize'>{{$current_user_name}}</span>
                    <i class="caret"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    @if($current_user->hasAccess(['users.profile_view']))
                    <li><a href="{{ route('update.profile') }}"><i class="icon-user-plus"></i> {{trans("comman.myprofile")}}</a></li>
                    @endif
                    <li><a href="{{ route('auth.logout') }}"><i class="icon-switch2"></i> {{trans("comman.logout")}}</a></li>
                </ul>
            </li>
        </ul>
    </div>
    @endif
</div>
<!-- /main navbar -->
<!-- Vertical navigation -->
@if(!Sentinel::guest())
<div class="navbar navbar-default" id="navbar-second">
    <ul class="nav navbar-nav no-border visible-xs-block">
        <li>
            <a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle">
                <i class="icon-menu7"></i>
            </a>
        </li>
    </ul>
    <div class="navbar-collapse collapse" id="navbar-second-toggle">
        <ul class="nav navbar-nav navbar-border">
            <li class="{{ (Request::segment(1)=='dashboard' ? 'active' : '' ) }}">
                <a href="{{ route('dashboard') }}"><i class="icon-home4 position-left"></i> <span>{{trans("comman.dashboard")}}</span>
                </a>
            </li>
            
           
            @if((Sentinel::getUser()->hasAccess(['users.view'])) || Sentinel::getUser()->hasAccess(['roles.view']))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-users position-left"></i> {{ trans('comman.admin_menu') }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu width-200">
                    @if(Sentinel::getUser()->hasAccess(['users.view']))
                    <li class="{{ (Request::segment(1)=='users' ? 'active' : '' ) }}"><a href="{{ route('users.index') }}"><i
                                class="icon-users"></i> <span>{{trans("comman.users")}}</span></a></li>
                    @endif
                   
                </ul>
            </li>
            @endif
            @if(Sentinel::getUser()->hasAccess(['currency.view']))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-users position-left"></i> {{ trans('comman.master_menu') }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu width-200">
                    @if(Sentinel::getUser()->hasAccess(["currency.view"]))
                        <li class="dropdown {{ (Request::segment(1)=='currency' ? 'active' : '' ) }}">
                            <a href="{{ route("currency.index") }}">
                                <i class="fa fa-bar-chart position-left"></i> Currency
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif

        
           
          

            {{--auto menu here--}}
                <li class="{{ (Request::segment(1)=='currency' ? 'active' : '' ) }}">
                    <a href="{{ route('currency.index') }}"><i class="icon-cog position-left"></i> <span>Category</span>
                    </a>
                </li>

                <li class="{{ (Request::segment(1)=='product' ? 'active' : '' ) }}">
                    <a href="{{ route('product.index') }}"><i class="icon-cog position-left"></i> <span>Product</span>
                    </a>
                </li>
        </ul>
    </div>
</div>
@endif
<!-- /Vertical navigation -->