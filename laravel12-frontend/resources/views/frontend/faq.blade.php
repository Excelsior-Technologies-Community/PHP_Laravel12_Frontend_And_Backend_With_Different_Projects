@extends('layouts.frontend')

@section('title', $lang('faq'))

@section('content')
    <section class="hero-gradient text-white py-5" style="min-height: 50vh; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 fw-bold mb-3">{{ $lang('faq') }}</h1>
                    <p class="lead">{{ $lang('faq_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="mb-4">
                        <input type="text" class="form-control" id="faqSearch" placeholder="{{ $lang('search_faq') }}...">
                    </div>

                    @foreach($faqs->groupBy('category_id') as $categoryId => $categoryFaqs)
                        <div class="glass-card p-4 mb-4 faq-category" data-category="{{ $categoryId }}">
                            <h4 class="fw-bold mb-3">{{ $categoryFaqs->first()->category->name ?? 'General' }}</h4>
                            <div class="accordion" id="faqAccordion{{ $categoryId }}">
                                @foreach($categoryFaqs as $index => $faq)
                                    <div class="accordion-item border-0 mb-2 faq-item">
                                        <h3 class="accordion-header" id="faqHeading{{ $categoryId }}{{ $index }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $categoryId }}{{ $index }}">
                                                {{ $faq->question }}
                                            </button>
                                        </h3>
                                        <div id="faqCollapse{{ $categoryId }}{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion{{ $categoryId }}">
                                            <div class="accordion-body">
                                                {{ $faq->answer }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#faqSearch').on('input', function() {
            const query = $(this).val().toLowerCase();
            $('.faq-item').each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(query));
            });
            $('.faq-category').each(function() {
                const hasVisible = $(this).find('.faq-item:visible').length > 0;
                $(this).toggle(hasVisible);
            });
        });
    });
</script>
@endsection
