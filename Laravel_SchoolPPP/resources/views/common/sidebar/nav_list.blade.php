<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
    <li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
        <a  href="/school/statistic" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-line-graph"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Save new data
                    </span>
                    {{--<span class="m-menu__link-badge">
                        <span class="m-badge m-badge--danger">
                            2
                        </span>
                    </span>--}}
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
        <a  href="/school/add" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-add-circular-button"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Add new school
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
        <a  href="/email" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-share"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Send charts to email
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__section">
        <h4 class="m-menu__section-text">
            Schools
        </h4>
        <i class="m-menu__section-icon flaticon-more-v3"></i>
    </li>
    
    @foreach($schoolsG as $school)
    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
        <a  href="#" class="m-menu__link m-menu__toggle">
            <i class="m-menu__link-icon flaticon-layers"></i>
            <span class="m-menu__link-text">
                {{ $school->name }}
            </span>
            <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu ">
            <span class="m-menu__arrow"></span>
            <ul class="m-menu__subnav">
                <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
                    <span class="m-menu__link">
                        <span class="m-menu__link-text">
                            {{ $school->name }}
                        </span>
                    </span>
                </li>
                <li class="m-menu__item " aria-haspopup="true" >
                    <a href="/school/{{ $school->id }}/list" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                            <span></span>
                        </i>
                        <span class="m-menu__link-text">
                            Data
                        </span>
                    </a>
                </li>
                <li class="m-menu__item " aria-haspopup="true" >
                    <a href="/school/{{ $school->id }}/graph" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                            <span></span>
                        </i>
                        <span class="m-menu__link-text">
                            Chart
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    @endforeach
    
</ul>