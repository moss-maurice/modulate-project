<!-- mainModule.tabs.main.index -->
<div class="container container-body">
    <div class="row form-row widgets">
        <div class="col-lg-12" id="welcome">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-home"></i>
                    Модули
                </div>
                <div class="card-block">
                    <div class="wm_buttons card-body border-0 m-3">
                        @if ($modules->isNotEmpty())
                            @foreach ($modules as $module)
                                <span class="wm_button">
                                    <a target="main" href="index.php?a=112&amp;id={{ $module->id() }}">
                                        <i class="{{ $module->icon() }} fa-2x fa-fw"></i>
                                        <span>{{ $module->name() }}</span>
                                    </a>
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / mainModule.tabs.main.index -->
