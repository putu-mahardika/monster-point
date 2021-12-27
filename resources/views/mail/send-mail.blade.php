@component('mail::message')
# Introduction

The body of your message.
@component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Alignedasadssfsfdsf | $20      |
@endcomponent

<h1>{{ $details['title'] }}</h1>
<p>{{ $details['body'] }}</p>
<table style="border: 1px solid black">
    <tr>
        <td>foo</td>
        <td>bar</td>
    </tr>
</table>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
