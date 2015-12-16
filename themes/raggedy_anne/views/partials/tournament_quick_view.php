<h3>Quick View</h3>
<table class="table table-condensed" style="margin-top:10px">
<tr>
    <td style="width: 180px">Participants</td>
    <td data-bind="text: $root.numberOfParticipants"></td>
</tr>
<tr>
    <td>Money From Bar</td>
    <td>$<span data-bind="text: $root.barDonation"></span></td>
</tr>
<tr>
    <td>Money From Players</td>
    <td>$<span data-bind="text: $root.moneyFromPlayers"></span></td>
</tr>
<tr>
    <td>Grand Total</td>
    <td>$<span data-bind="text: $root.grandTotal"></span></td>
</tr>
</table>
