@extends(config('seo.layout'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('seo::dashboard.index')}}"> Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('seo::pages.index')}}">Pages</a></li>
    <li class="breadcrumb-item">{{pathinfo($record->path,PATHINFO_BASENAME)}}</li>
@endsection
@section('tools')
    &nbsp;
    <a href="{{route('seo::pages.edit',$record->id)}}"><i class="fa fa-pencil"></i></a>
    &nbsp;
    <a target="_blank" href="{{url($record->path)}}">Visit Page</a>
    &nbsp;&nbsp;
    <a target="_blank"
       href="https://developers.facebook.com/tools/debug/sharing/?q={{urlencode($record->getFullUrl())}}">
        <i class="fa fa-facebook-official"></i> Facebook Validate
    </a>
    &nbsp;&nbsp;
    <a href="https://cards-dev.twitter.com/validator" target="_blank">
        <i class="fa fa-twitter"></i> Twiter Card Validate
    </a>
    &nbsp;
    <a target="_blank"
       href="https://developers.google.com/speed/pagespeed/insights/?url={{urlencode($record->getFullUrl())}}">
        <i class="fa fa-google"></i> Google Page Speed
    </a>
@endsection
@section('content')
    <div class="row">
        @if(isset($success) && !empty($success))
            <div class="col-sm-9">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>Meta Title</th>
                        <td>
                            @if(strlen($title)>0)
                                <span class="h4">
                                   {{$title}}
                                </span>
                            @else
                                <i class="fa fa-remove text-danger fa-3x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Meta Description</th>
                        <td>
                            @if(isset($metas['description']) && !empty($metas['description']))
                                <span class="">
                                    {{$metas['description']['content'] or ''}}
                               </span>
                            @else
                                <i class="fa fa-remove text-danger fa-3x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Other Meta</th>
                        <td>
                            <div id="accordionMetaTags" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    <div class="card-title" role="tab" id="headingMetaTags">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" data-parent="#accordionMetaTags"
                                               href="#collapseMetaTags"
                                               aria-expanded="false" aria-controls="collapse">
                                                &nbsp;&nbsp;
                                                <label><b>{{count($metas)}}</b>

                                                </label> found <i class="fa fa-arrow-down"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseMetaTags" class="collapse hide" role="tabpanel"
                                         aria-labelledby="headingMetaTags">
                                        <div class="card-block">
                                            <ul class="list-group">
                                                @foreach($metas as $m)
                                                    <li class="list-group-item">
                                                        <code>
                                                            &lt;meta @foreach($m as $p=>$v)
                                                                {{$p."="."\"$v\""}}
                                                            @endforeach
                                                            /&gt;
                                                        </code>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>H1 heading status</th>
                        <td>
                            @if(isset($headings['h1']) && count($headings['h1'])>0)
                                @include('seo::includes.heading-analysis',['level'=>1,'tags'=>$headings['h1']])
                            @else
                                <i class="fa fa-remove text-danger fa-3x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>H2 heading status</th>
                        <td>
                            @if(isset($headings['h2']) && count($headings['h2'])>0)
                                @include('seo::includes.heading-analysis',['level'=>2,'tags'=>$headings['h2']])
                            @else
                                <i class="fa fa-remove text-danger fa-2x"></i>
                            @endif

                        </td>
                    </tr>
                    <tr>
                        <th>H3 heading status</th>
                        <td>
                            @if(isset($headings['h3']) && count($headings['h3'])>0)
                                @include('seo::includes.heading-analysis',['level'=>3,'tags'=>$headings['h3']])
                            @else
                                <i class="fa fa-remove text-danger fa-2x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>CSS files</th>
                        <td>
                            <div id="accordionCssFiles" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    <div class="card-title" role="tab" id="headingCssFiles">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" data-parent="#accordionCssFiles"
                                               href="#collapseCssFiles"
                                               aria-expanded="false" aria-controls="collapse">
                                                &nbsp;&nbsp;
                                                <label><b>{{count($css)}}</b>

                                                </label> found <i class="fa fa-arrow-down"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseCssFiles" class="collapse hide" role="tabpanel"
                                         aria-labelledby="headingCssFiles">
                                        <div class="card-block">
                                            <table class="table table-bordered">
                                                @foreach($css as $f)
                                                    <tr>
                                                        <td>{{$f['href'] or ''}}</td>
                                                        <td>{{$f['size'] or ''}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>JavaScript files</th>
                        <td>
                            <div id="accordionJsFiles" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    <div class="card-title" role="tab" id="headingJsFiles">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" data-parent="#accordionJsFiles"
                                               href="#collapseJsFiles"
                                               aria-expanded="false" aria-controls="collapse">
                                                &nbsp;&nbsp;
                                                <label><b>{{count($js)}}</b>

                                                </label> found <i class="fa fa-arrow-down"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseJsFiles" class="collapse hide" role="tabpanel"
                                         aria-labelledby="headingJsFiles">
                                        <div class="card-block">
                                            <table class="table table-bordered">
                                                @foreach($js as $f)
                                                    <tr>
                                                        <td>{{$f['src'] or ''}}</td>
                                                        <td>{{$f['size'] or ''}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Anchor</th>
                        <td>
                            <div id="accordionAnchor" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    <div class="card-title" role="tab" id="headingAnchor">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" data-parent="#accordionAnchor"
                                               href="#collapseAnchor"
                                               aria-expanded="false" aria-controls="collapse">
                                                &nbsp;&nbsp;
                                                <label><b>{{count($anchors)}}</b>

                                                </label> found <i class="fa fa-arrow-down"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseAnchor" class="collapse hide" role="tabpanel"
                                         aria-labelledby="headingAnchor">
                                        <div class="card-block">
                                            <table class="table table-bordered">
                                                @foreach($anchors as $f)
                                                    <tr>
                                                        <td>{{$f['href'] or ''}}</td>
                                                        <td>{{$f['text'] or ''}}</td>
                                                        <td>
                                                            <label class="badge {{empty($f['internal'])?' badge-warning':' badge-default'}} ">{{empty($f['internal'])?' External':' Internal'}}</label>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th>Loading Time</th>
                        <td><a href="#">Update To Pro</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-3">
                <p class="lead border-light border bg-light">
                    &nbsp;<label class="badge badge-info"> {{$size}} KB</label> total page size
                </p>
                @if(count($images) >0)
                    @foreach($images as $image)
                        <div class="card mb-2">
                            <?php if (isset($image['src']) && !empty($image['src'])): ?>
                            <img src="{{$image['src']}}" class="card-img-top img-responsive">
                            <?php endif; ?>
                            <div class="card-body mb-0 p-1">
                                <div class="card-title">
                                    @if (isset($image['alt']) && !empty($image['alt']))
                                        <small class="text-muted">{{$image['alt']}}</small>
                                    @else
                                        <i class="fa fa-remove text-danger fa-2x"></i> No Alt attribute found
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                @if (isset($image['src']) && !empty($image['src']))

                                    @if(isset($image['width']) && isset($image['height']))
                                        &nbsp;<label class="badge badge-secondary"> {{$image['width']}}px
                                            x {{$image['height']}}px</label>
                                    @endif

                                    @if(isset($image['mime']))
                                        <label class="badge badge-secondary">{{$image['mime']}}</label>
                                    @endif

                                    &nbsp;@if(isset($image['size']))
                                        <label class="badge badge-secondary">
                                            {{$image['size']}} kb
                                        </label>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach

                @else
                    <i class="fa fa-remove text-danger fa-2x"></i> No image found
                @endif
            </div>
        @else
            <div class="alert alert-warning">Page does not exists</div>
        @endif

    </div>
@endSection