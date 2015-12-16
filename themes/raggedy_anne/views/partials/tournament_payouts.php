<h3>Suggested Payouts</h3>
<table class="table table-condensed">
<tbody data-bind="foreach: $root.suggested_payouts()">
    <tr>
        <td style="width: 180px" data-bind="text: place"></td>
        <td data-bind="text: payout"></td>
    </tr>
</tbody>
</table>

<table class="table table-condensed">
<tr>
    <td style="width: 180px">High Dart</td>
    <td>$<span data-bind="text: $root.payouts().high_dart"></span></td>
</tr>
<tr>
    <td>High Out</td>
    <td>$<span data-bind="text: $root.payouts().high_out"></span></td>
</tr>
<tr data-bind="visible: $root.hasHoneyPot">
    <td>Honey Pot</td>
    <td>$<span data-bind="text: $root.payouts().honey_pot"></span></td>
</tr>
<tr>
    <td>Mystery Out</td>
    <td>$<span data-bind="text: $root.payouts().mystery_out"></span></td>
</tr>
</table>
