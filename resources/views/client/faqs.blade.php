@extends('layouts.client')

@push('title')
    <title> الرئيسية - الأسئلة الشائعة </title>
@endpush
@push('script')
    @vite('resources/js/faqs.js')
@endpush
@section('content')
    <main id="faqs">

        <div class="container">
            <h1 class="page-title"> الأسئلة الشائعة </h1>
            <x-breadcrumb prevUrl="{{ route('client.home') }}" prevValue="الرئيسية" currUrl="{{ route('client.faqs') }}"
                currValue=" الأسئلة الشائعة" />
        </div>
        <div class="container">
            <div class="faqs-grid grid">
                <div class="tabs-filters">
                    <ul>
                        <li> <button data-index="1" aria-checked="true"></button>
                            <h2 class="d">الحساب</h2>
                        </li>
                        <li> <button data-index="2"></button>
                            <h2>الطلبات</h2>
                        </li>
                        <li> <button data-index="3"></button>
                            <h2>سياسة الإرجاع</h2>
                        </li>
                    </ul>
                </div>
                <div class="tabs-holder">
                    <!-- Start Tab -->
                    <div class="tab" data-tab="1" aria-expanded="true">

                        <!-- Start Accordion -->
                        <div class="accordion">
                            <div class="accordion-header">
                                <h3> النص هو مثال لنص يمكن استبداله في نفس المساحة. </h3>
                                <button aria-checked="true"></button>
                            </div>
                            <div class="accordion-body">
                                <p> arهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
                                    النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة
                                    عدد
                                    الحروف التى يولدها التطبيق. </p>
                            </div>
                        </div>
                        <!-- End Accordion -->
                        <!-- Start Accordion -->
                        <div class="accordion">
                            <div class="accordion-header">
                                <h3> النص هو مثال لنص يمكن استبداله في نفس المساحة. </h3>
                                <button></button>
                            </div>
                            <div class="accordion-body">
                                <p> arهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
                                    النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة
                                    عدد
                                    الحروف التى يولدها التطبيق. </p>
                            </div>
                        </div>
                        <!-- End Accordion -->
                        <!-- Start Accordion -->
                        <div class="accordion">
                            <div class="accordion-header">
                                <h3> النص هو مثال لنص يمكن استبداله في نفس المساحة. </h3>
                                <button></button>
                            </div>
                            <div class="accordion-body">
                                <p> arهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
                                    النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة
                                    عدد
                                    الحروف التى يولدها التطبيق. </p>
                            </div>
                        </div>
                        <!-- End Accordion -->
                    </div>
                    <!-- End Tab -->
                    <!-- Start Tab -->
                    <div class="tab" data-tab="2">

                        <!-- Start Accordion -->
                        <div class="accordion">
                            <div class="accordion-header">
                                <h3> النص هو مثال لنص يمكن استبداله في نفس المساحة. </h3>
                                <button></button>
                            </div>
                            <div class="accordion-body">
                                <p> arهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
                                    النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة
                                    عدد
                                    الحروف التى يولدها التطبيق. </p>
                            </div>
                        </div>
                        <!-- End Accordion -->
                        <!-- Start Accordion -->
                        <div class="accordion">
                            <div class="accordion-header">
                                <h3> النص هو مثال لنص يمكن استبداله في نفس المساحة. </h3>
                                <button></button>
                            </div>
                            <div class="accordion-body">
                                <p> arهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
                                    النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة
                                    عدد
                                    الحروف التى يولدها التطبيق. </p>
                            </div>
                        </div>
                        <!-- End Accordion -->
                        <!-- Start Accordion -->
                        <div class="accordion">
                            <div class="accordion-header">
                                <h3> النص هو مثال لنص يمكن استبداله في نفس المساحة. </h3>
                                <button></button>
                            </div>
                            <div class="accordion-body">
                                <p> arهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
                                    النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة
                                    عدد
                                    الحروف التى يولدها التطبيق. </p>
                            </div>
                        </div>
                        <!-- End Accordion -->
                    </div>
                    <!-- End Tab -->
                    <!-- Start Tab -->
                    <div class="tab" data-tab="3">

                        <!-- Start Accordion -->
                        <div class="accordion">
                            <div class="accordion-header">
                                <h3> النص هو مثال لنص يمكن استبداله في نفس المساحة. </h3>
                                <button></button>
                            </div>
                            <div class="accordion-body">
                                <p> arهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
                                    النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة
                                    عدد
                                    الحروف التى يولدها التطبيق. </p>
                            </div>
                        </div>
                        <!-- End Accordion -->
                        <!-- Start Accordion -->
                        <div class="accordion">
                            <div class="accordion-header">
                                <h3> النص هو مثال لنص يمكن استبداله في نفس المساحة. </h3>
                                <button></button>
                            </div>
                            <div class="accordion-body">
                                <p> arهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
                                    النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة
                                    عدد
                                    الحروف التى يولدها التطبيق. </p>
                            </div>
                        </div>
                        <!-- End Accordion -->
                        <!-- Start Accordion -->
                        <div class="accordion">
                            <div class="accordion-header">
                                <h3> النص هو مثال لنص يمكن استبداله في نفس المساحة. </h3>
                                <button></button>
                            </div>
                            <div class="accordion-body">
                                <p> arهذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
                                    النص
                                    العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة
                                    عدد
                                    الحروف التى يولدها التطبيق. </p>
                            </div>
                        </div>
                        <!-- End Accordion -->
                    </div>
                    <!-- End Tab -->
                </div>
            </div>
        </div>
    </main>
@endsection
