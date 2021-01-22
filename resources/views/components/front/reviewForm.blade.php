<div class="margin-70px-top  row" id="review">

    <div class="col-lg-6 order-lg-2 sm-margin-30px-bottom">
        <div class="common-block">
            <div class="line-title">
                <h4 class="no-margin-bottom">Reviews (<span class="review_count">0</span>)</h4>
            </div>
            <div class="review_result">

            </div>
        </div>
    </div>

    <div class="col-lg-6 order-lg-1">
        <div class="common-block">

            <div class="line-title">
                <h4 class="no-margin-bottom">Leave Review</h4>
            </div>

            <form method="post" action="{{route('review.store')}}" id="review_form">
                @csrf
                @honeypot
                <input type="hidden" name="type" value="{{$type}}">
                <input type="hidden" name="model_id" value="{{$id}}">

                <div class="row">
                    @guest
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Your name here" class="fcustom-input">
                                <div class="form-control-feedback error-name"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Your email here" class="fcustom-input">
                                <div class="form-control-feedback error-email"></div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" name="name" class="fcustom-input" value="{{user()->name}}" readonly disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="email" name="email" class="fcustom-input" value="{{user()->email}}" readonly disabled>
                            </div>
                        </div>
                    @endguest
                    <div class="col-sm-12">

                        <div class="form-group">
                            <label for="rating">Choose rating</label>
                            <div id="rating" class="pl-0" data-rateyo-spacing="10px"></div>
                            <input type="hidden" name="rating">
{{--                            <select class="fcustom-input" name="rating">--}}
{{--                                <option selected disabled hidden>Ratings</option>--}}
{{--                                <option value="5">5 Stars</option>--}}
{{--                                <option value="4">4 Stars</option>--}}
{{--                                <option value="3">3 Stars</option>--}}
{{--                                <option value="2">2 Stars</option>--}}
{{--                                <option value="1">1 Star</option>--}}
{{--                            </select>--}}
                            <div class="form-control-feedback error-rating"></div>
                        </div>

                    </div>

                    <div class="col-sm-12">

                        <div class="form-group">
                            <textarea id="comment" name="comment"  placeholder="Tell us a few words" class="fcustom-input minh-100 white"></textarea>
                            <div class="form-control-feedback error-comment"></div>
                        </div>

                    </div>

                </div>

                <button type="submit" class="btn btn-success smtBtn">Leave Review</button>

            </form>

        </div>

    </div>
</div>
