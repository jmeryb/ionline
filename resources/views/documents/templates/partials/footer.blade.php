<footer>
    <table width="100%">
        <tr>
            <td width="20%">
                <div style="width: 120px;">
                    <div style="float: left; width: 41%; height: 6px; background-color: #0168B3;"></div>
                    <div style="float: right; width: 59%; height: 6px; background-color: #EE3A43;"></div>
                    <div style="clear: both;"></div>
                </div>
            </td>
            <td class="center" style="font-size: 8px;">
                {{ $document->establishment->address }} - 
                {{ $document->establishment->telephone }} - 
                {{ $document->establishment->url }}
            </td>
            <td width="20%" class="right" >
            <img src="{{ public_path('/images/footer-gob.png') }}" width="100" alt="Logo de la institución">

            </td>
        </tr>
    </table>
</footer>