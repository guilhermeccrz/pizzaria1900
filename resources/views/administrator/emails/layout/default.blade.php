<html>

<body>

<table style="width: 100%;">
    <tr>
        <td>
            <img src="{{ asset('images/emails/header.jpg') }}" />
        </td>
    </tr>
    <tr>
        <td>
            @yield('content')
        </td>
    </tr>
    <tr>
        <td>
            <img src="{{ asset('images/emails/footer.jpg') }}" />
        </td>
    </tr>
</table>

</body>

</html>