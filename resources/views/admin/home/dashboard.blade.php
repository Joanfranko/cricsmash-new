@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="owl-carousel owl-carousel2 owl-theme mb-5">
                <div class="item">
                    <div class="card mb-0">
                        <div class="row">
                            <div class="col-4">
                                <div class="feature">
                                    <div class="fa-stack fa-lg fa-2x icon bg-primary-transparent">
                                        <i class="si si-briefcase  fa-stack-1x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card-body p-3  d-flex">
                                    <div>
                                        <p class="text-muted mb-1">Total Income</p>
                                        <h2 class="mb-0 text-dark">18,367K</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card mb-0">
                        <div class="row">
                            <div class="col-4">
                                <div class="feature">
                                    <div class="fa-stack fa-lg fa-2x icon bg-success-transparent">
                                        <i class="si si-drawer fa-stack-1x text-success"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card-body p-3  d-flex">
                                    <div>
                                        <p class="text-muted mb-1">Total Profit</p>
                                        <h2 class="mb-0 text-dark">35%</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card mb-0">
                        <div class="row">
                            <div class="col-4">
                                <div class="feature">
                                    <div class="fa-stack fa-lg fa-2x icon bg-pink-transparent">
                                        <i class="si si-layers fa-stack-1x text-pink"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card-body p-3  d-flex">
                                    <div>
                                        <p class="text-muted mb-1">Total Revenue</p>
                                        <h2 class="mb-0 text-dark">3,548K</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card mb-0">
                        <div class="row">
                            <div class="col-4">
                                <div class="feature">
                                    <div class="fa-stack fa-lg fa-2x icon bg-warning-transparent">
                                        <i class="si si-chart fa-stack-1x text-warning"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card-body p-3  d-flex">
                                    <div>
                                        <p class="text-muted mb-1">Total Sales</p>
                                        <h2 class="mb-0 text-dark">9,756</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection