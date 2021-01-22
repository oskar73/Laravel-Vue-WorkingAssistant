<h2>Hi !</h2> <br><br>

You received an email from : {{ $data['first_name'] }} {{ $data['last_name'] }} <br><br>

<h2>User details:</h2>
<br>
<br>
Name: {{ $data['first_name'] }} {{ $data['last_name'] }}<br>

Email: {{ $data['email'] }}<br>

Subject: {{ $data['subject'] }}<br>

@if ($data['phone'])
  Phone: {{ $data['phone'] }}<br>
@endif

@if ($data['date'])
  Date: {{ $data['date'] }}<br>
@endif

@if ($data['address'])
  Address: {{ $data['address'] }}<br>
@endif

@if ($data['message'])
  Message: {!! $data['message'] !!}<br><br>
@endif


Thanks
