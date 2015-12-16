PlayerModel = function(master, player){
    var self = this;
    var _honey_pot = master.tournament.honey_pot && player.honey_pot;

    self.id = ko.observable(player.id);
    self.player_id = ko.observable(player.player_id);
    self.name = ko.observable(player.name);
    self.high_dart = ko.observable(player.high_dart);
    self.high_out = ko.observable(player.high_out);
    self.mystery_out = ko.observable(player.mystery_out);
    self.honey_pot = ko.observable(_honey_pot);
    self.female = ko.observable(player.female);
    self.chip_pulled = ko.observable(player.chip_pulled);
    self.xman = ko.observable(player.xman);

    self.entry_fee = ko.computed(function(){
        var total = (self.xman()) ? parseFloat(master.tournament.xman()) : parseFloat(master.tournament.entry_fee());

        if(self.high_dart()) total += parseFloat(master.tournament.high_dart_fee());
        if(self.high_out()) total += parseFloat(master.tournament.high_out_fee());
        if(self.mystery_out()) total += parseFloat(master.tournament.mystery_out_fee());
        if(self.honey_pot()) total += parseFloat(master.tournament.honey_pot_fee());

        return total.toFixed(2);
    }, self);

    self.is_female = ko.computed(function(){
        return (self.female()) ? "Y": "";
    }, self);

    return self;
};
