<div class="col-sm-12">
    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
        <h4 class="page-title text-capitalize">{{ $breadcrumbs[count($breadcrumbs) - 1]['title'] ?? 'Dashboard' }}</h4>
        <div class="">
            <ol class="breadcrumb mb-0">
                @foreach ($breadcrumbs as $index => $breadcrumb)
                    @if (isset($breadcrumb['url']) && $index !== count($breadcrumbs) - 1)
                        <li class="breadcrumb-item text-capitalize"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                    @else
                        <li class="breadcrumb-item text-capitalize active">{{ $breadcrumb['title'] }}</li>
                    @endif
                @endforeach
            </ol>
        </div>
    </div><!--end page-title-box-->
</div><!--end col-->
