TournamentModel = function(tournament){
    var self = this;
    self.id = ko.observable(tournament.id);
    self.date = ko.observable(tournament.date);
    self.entry_fee = ko.observable(tournament.entry_fee);
    self.bar_match = ko.observable(tournament.bar_match);
    self.xman = ko.observable(tournament.xman);
    self.auto_generate_teams = ko.observable(tournament.auto_generate_teams);
    self.high_dart = ko.observable(tournament.high_dart);
    self.high_out = ko.observable(tournament.high_out);
    self.mystery_out = ko.observable(tournament.mystery_out);
    self.honey_pot = ko.observable(tournament.honey_pot);
    self.high_dart_fee = ko.observable(tournament.high_dart_fee);
    self.high_out_fee = ko.observable(tournament.high_out_fee);
    self.mystery_out_fee = ko.observable(tournament.mystery_out_fee);
    self.honey_pot_fee = ko.observable(tournament.honey_pot_fee);
    self.teams_selected = ko.observable(tournament.teams_selected);

    return self;
};
