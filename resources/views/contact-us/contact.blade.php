<h2>Hey, It's me {{ $data->name ?? 'N/A' }}</h2> 

<strong>Name:</strong> {{ $data->name ?? 'N/A' }} <br>
<strong>Email:</strong> {{ $data->email ?? 'N/A' }} <br>
<strong>Phone:</strong> {{ $data->phone ?? 'N/A' }} <br>
<strong>Subject:</strong> {{ $data->subject ?? 'N/A' }} <br>
<strong>Message:</strong> {{ $data->body ?? 'N/A' }} <br>
