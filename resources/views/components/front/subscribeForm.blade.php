<div class="newsletter_container">
    <div class="one">
        <div class="close_one close_btn">&times;</div>
        <div class="logo">
            <img src="https://image.flaticon.com/icons/svg/143/143361.svg">
        </div>
        <h2 class="heading">
            Subscribe to newsletter
        </h2>
        <form action="{{route("subscribe")}}" class="newsletter_subscribe_form" method="POST">
            @csrf
            @honeypot

            <input type='text' placeholder="enter your email" name="email" autocomplete="off" required><br/>
            <div class="form-control-feedback error-email"></div>
            <button class="btn mt-3" type="submit">
                subscribe
            </button>
        </form>
    </div>
</div>

