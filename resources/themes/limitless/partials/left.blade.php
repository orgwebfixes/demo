<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-default">
    <div class="sidebar-content">
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-title h6">
                <span>{{trans("comman.main_navigation")}}</span>
                <ul class="icons-list">
                    <li><a href="#" data-action="collapse"></a></li>
                </ul>
            </div>
            <div class="category-content sidebar-user">
                <div class="media">
                    <a class="media-left">
                        @if(isset($current_user->image) && !empty($current_user->image))
                        {{Html::image(AppHelper::path('uploads/user/')->size('36x36')->getImageUrl(Sentinel::getUser()->image),'User Photo',array("class"=>"img-circle"))}}

                        @else
                        {{Html::image(AppHelper::size('36x36')->getImageUrl(),'User Photo',array("class"=>"img-circle staff"))}}
                        @endif
                    </a>
                    <div class="media-body">
                        <span class="media-heading text-capitalize text-bold">{{$current_user_name}}</span>
                        @if(!empty($cityname) || !empty($statename))
                        <div class="text-size-mini text-muted">
                            <i class="icon-pin text-size-small"></i> &nbsp;{{$cityname}} {{!empty($cityname)? ',' : ''}}{{$statename}}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">
                    <!-- Main -->
                    <li class="{{ (Request::segment(2)=='dashboard' ? 'active' : '' ) }}"><a href="{{ route('dashboard') }}"><i class="icon-home4"></i> <span>{{trans("comman.dashboard")}}</span></a></li>
                    @if($current_user->hasAccess(['recharge.recharge']))
                    <li class="{{ (Request::segment(2)=='recharge' ? 'active' : '' ) }}"><a href="{{ route('user.recharge') }}"><i class="icon-mobile2"></i> <span>{{trans("comman.recharge")}}</span></a></li>
                    @endif
                    @if (Sentinel::check() && Sentinel::inRole('administrator'))
                    <li class="{{ (Request::segment(2)=='users' ? 'active' : '' ) }}"><a href="{{ route('users.index') }}"><i class="icon-users"></i> <span>{{trans("comman.users")}}</span></a></li>
                    <li class="{{ (Request::segment(2)=='roles' ? 'active' : '' ) }}"><a href="{{ route('roles.index') }}"><i class="icon-people"></i> <span>{{trans("comman.roles")}}</span></a></li>
                    @endif
                    <!-- Country,State -->
                    @if(Sentinel::getUser()->hasAccess(['countries.view']))
                    <li class="{{ (Request::segment(2)=='countries' ? 'active' : '' ) }}"><a href="{{ route('countries.index') }}"><i class="icon-cc"></i> <span>{{trans("comman.country")}}</span></a></li>
                    @endif
                    @if(Sentinel::getUser()->hasAccess(['states.view']))
                    <li class="{{ (Request::segment(2)=='states' ? 'active' : '' ) }}"><a href="{{ route('states.index') }}"><i class="icon-lastfm2"></i> <span>{{trans("comman.state")}}</span></a></li>
                    @endif
                    {{-- Activity --}}
                    @if(Sentinel::getUser()->hasAccess(['activities.view']))
                    <li class="{{ (Request::segment(2)=='activities' ? 'active' : '' ) }}"><a href="{{ route('activities.index') }}"><i class=" icon-gear"></i> <span>{{trans("comman.activity")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['ticket_status.view']))
                    <li class="{{ (Request::segment(2)=='ticketstatus' ? 'active' : '' ) }}"><a href="{{ route('ticketstatus.index') }}"><i class="icon-stack3"></i> <span>{{trans("comman.ticket_status")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['check_lists.view']))
                    <li class="{{ (Request::segment(2)=='checklists' ? 'active' : '' ) }}"><a href="{{ route('checklists.index') }}"><i class="icon-newspaper"></i> <span>{{trans("comman.check_lists")}}</span></a></li>
                    @endif
                    {{-- Version --}}
                    <li class="{{ (Request::segment(2)=='versions' ? 'active' : '' ) }}"><a href="{{ route('versions.index') }}"><i class="icon-coin-yen"></i> <span>{{trans("comman.version")}}</span></a></li>

                    @if(Sentinel::getUser()->hasAccess(['projectStatus.view']))
                    <li class="{{ (Request::segment(2)=='project_status' ? 'active' : '' ) }}"><a href="{{ route('projectStatus.index') }}"><i class="icon-newspaper2"></i> <span>{{trans("comman.project_status")}}</span></a></li>
                    @endif
                    {{-- Project --}}
                    @if(Sentinel::getUser()->hasAccess(['projects.view']))
                    <li class="{{ (Request::segment(2)=='projects' ? 'active' : '' ) }}"><a href="{{ route('projects.index') }}"><i class="icon-stack"></i> <span>{{trans("comman.project")}}</span></a></li>
                    @endif    
                    {{-- Tracker --}}
                    @if(Sentinel::getUser()->hasAccess(['trackers.view']))
                    <li class="{{ (Request::segment(2)=='trackers' ? 'active' : '' ) }}"><a href="{{ route('trackers.index') }}"><i class="icon-file-eye2"></i> <span>{{trans("comman.tracker")}}</span></a></li>
                    @endif 
                    {{-- Spent Time --}}
                    @if(Sentinel::getUser()->hasAccess(['spent_times.view']))
                    <li class="{{ (Request::segment(2)=='spent_times' ? 'active' : '' ) }}"><a href="{{ route('spent_times.index') }}"><i class="icon-mirror"></i> <span>{{trans("comman.spent_time")}}</span></a></li>
                    @endif 
                    @if(Sentinel::getUser()->hasAccess(['technicalReq.view']))
                    <li class="{{ (Request::segment(2)=='technicalReq' ? 'active' : '' ) }}">
                        <a href="{{ route('technicalReq.index') }}">
                            <i class="icon-magazine"></i> 
                            <span>{{trans("comman.technical_req")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['srtpl_points.view']))
                    <li class="{{ (Request::segment(2)=='srtpl_points' ? 'active' : '' ) }}">
                        <a href="{{ route('srtpl_points.index') }}">
                            <i class="icon-point-right"></i> <span>{{trans("comman.srtpl_points")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['priority.view']))
                    <li class="{{ (Request::segment(2)=='priority' ? 'active' : '' ) }}"><a href="{{ route('priority.index') }}">
                            <i class="icon-color-sampler"></i> <span>{{trans("comman.priority")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['ticketSource.view']))
                    <li class="{{ (Request::segment(2)=='ticketSource' ? 'active' : '' ) }}"><a href="{{ route('ticketSource.index') }}">
                            <i class="fa fa-bullhorn"></i> <span>{{trans("comman.ticket_source")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['client.view']))
                    <li class="{{ (Request::segment(2)=='client' ? 'active' : '' ) }}"><a href="{{ route('client.index') }}"><i class="icon-clippy"></i> <span>{{trans("comman.client")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['incedent_template.view']))
                    <li class="{{ (Request::segment(2)=='incedent_template' ? 'active' : '' ) }}">
                        <a href="{{ route('incedent_template.index') }}">
                            <i class="icon-file-text2"></i> 
                            <span>{{trans("comman.incedent_template")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['incedents.view']))
                    <li class="{{ (Request::segment(2)=='incedents' ? 'active' : '' ) }}">
                        <a href="{{ route('incedents.index') }}">
                            <i class="icon-certificate"></i> 
                            <span>{{trans("comman.incedent")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['tickets.view']))
                    <li class="{{ (Request::segment(2)=='tickets' ? 'active' : '' ) }}"><a href="{{ route('tickets.index') }}">
                            <i class="icon-profile"></i> <span>{{trans("comman.tickets")}}</span></a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['ticket_check_list.view']))
                    <li class="{{ (Request::segment(2)=='ticket_check_list' ? 'active' : '' ) }}">
                        <a href="{{ route('ticket_check_list.index') }}">
                            <i class="fa fa-check-square-o"></i> 
                            <span>{{trans("comman.ticket_check_list")}}</span>
                        </a></li>
                    @endif
                    @if(Sentinel::getUser()->hasAccess(['reports.team_task']))
                    <li class="{{ (Request::segment(2)=='TeamTaskReport' ? 'active' : '' ) }}"><a href="{{ route('TeamTaskReport.index') }}">
                            <i class="icon-collaboration"></i> <span>{{trans("comman.team_task_report")}}</span></a></li>
                    @endif
                    @if(Sentinel::getUser()->hasAccess(['project_spent_time.view']))
                    <li class="{{ (Request::segment(2)=='project_spent_time' ? 'active' : '' ) }}">
                        <a href="{{ route('project_spent_time.index') }}">
                            <i class="icon-sort-time-asc"></i> 
                            <span>{{trans("comman.project_spent_time")}}</span>
                        </a></li>
                    @endif

                    @if(Sentinel::getUser()->hasAccess(['roadmap.view']))
                    <li class="{{ (Request::segment(2)=='roadmap' ? 'active' : '' ) }}">
                        <a href="{{ route('roadmap.index') }}">
                            <i class="icon-sphere"></i> 
                            <span>{{trans("comman.roadmap")}}</span>
                        </a></li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- /main navigation -->
    </div>
</div>
<!-- /main sidebar -->
