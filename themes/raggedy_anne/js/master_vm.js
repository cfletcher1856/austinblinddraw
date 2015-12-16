MasterVM = function(tournament){
    var self = this;
    self.tournament = new TournamentModel(tournament);

    self.players = ko.observableArray([]);
    self.selected_xman = ko.observable();

    self.xman = ko.computed(function(){
        var _xman;
        _.each(self.players(), function(player){
            if(player.xman()){
                _xman = player;
            }
        });

        return _xman;
    });

    self.split_players = ko.computed(function(){
        var columns = 2;
        var items = self.players().length;
        var itemsPerColumn = items / columns;

        var top = [];
        var bottom = [];

        for(var i = 0; i < itemsPerColumn; i++){
            for(var j = 0; j < columns; j++){
                if(j === 0){
                    top.push(self.players()[(j * itemsPerColumn) + i]);
                } else {
                    bottom.push(self.players()[(j * itemsPerColumn) + i]);
                }
            }
        }

        return {
            top: top,
            bottom: bottom
        };
    });

    self.setXman = function(_player){
        _.each(self.players(), function(player){
            if(_player.id() !== player.id()){
                player.xman(false);
            }
        });

        return true;
    };

    self.hasHoneyPot = ko.computed(function(){
        return self.tournament.honey_pot();
    }, self);

    self.pullChip = ko.computed(function(){
        return self.tournament.auto_generate_teams();
    });

    self.teams_selected = ko.computed(function(){
        return self.tournament.teams_selected();
    });

    self.moneyFromPlayers = ko.computed(function(){
        var total = 0.00;
        _.each(self.players(), function(player){
            total += parseFloat(player.entry_fee());
        });

        return total.toFixed(2);
    }, self);

    self.barDonation = ko.computed(function(){
        var donation = parseFloat(self.tournament.bar_match()) * parseFloat(self.players().length);
        return donation.toFixed(2);
    });

    self.grandTotal = ko.computed(function(){
        var total = parseFloat(self.moneyFromPlayers()) + parseFloat(self.barDonation());

        return total.toFixed(2);
    });

    self.hasXman = ko.computed(function(){
        var cnt = 0;
        _.each(self.players(), function(player){
            if(!player.xman())
            {
                cnt++;
            }
        });

        return cnt % 2 !== 0;
    });

    self.numberOfParticipants = ko.computed(function(){
        return self.players().length;
    });

    self.setPlayers = function(){
        _.each(window.REGISTERED_PLAYERS, function(player){
            self.players.push(new PlayerModel(self, player));
        });

        self.sortPlayers();
    };

    self.sortPlayers = function(){
        self.players.sort(function(left, right){
            return left.name() == right.name() ? 0 : (left.name() < right.name() ? -1 : 1);
        });
    };

    self.addplayertodbandtournament = function(){
        $.getJSON('/director/tournament/addplayertodbandtournament', {
            data:{
                tournament_id: self.tournament.id(),
                player: {
                    name: $("#Player_name").val(),
                    nickname: $("#Player_nickname").val(),
                    high_dart: true,
                    high_out: true,
                    mystery_out: true,
                    honey_pot: self.tournament.honey_pot(),
                    female: $("#Player_female").is(':checked')
                }
            }
        }, function(data){
            if(data.status == 'success'){
                var player_obj = data.player;
                var player = new PlayerModel(self, {
                    id: data.id,
                    player_id: player_obj.id,
                    name: player_obj.name,
                    high_dart: true,
                    high_out: true,
                    mystery_out: true,
                    honey_pot: self.tournament.honey_pot(),
                    female: player_obj.female
                });

                self.players.push(player);
                self.sortPlayers();
                $("#addplayer_modal").modal('hide');
            } else {
                alert(data.status + ". The player was not added to the tournament");
            }
        });
    };

    self.addPlayer = function(){
        var player_name = $("#player").val();
        var player_obj = window.PLAYERS[player_name];
        var return_early = false;

        _.each(self.players(), function(player){
            if(player.name() === player_name)
            {
                return_early = true;
                $("#player").val('');
            }
        });

        if(return_early) return;

        if(player_obj !== undefined){
            $.getJSON('/director/tournament/addplayertotournament', {
                data:{
                    tournament_id: self.tournament.id(),
                    player: {
                        id: player_obj.id,
                        name: player_obj.name,
                        high_dart: true,
                        high_out: true,
                        mystery_out: true,
                        honey_pot: self.tournament.honey_pot(),
                        female: player_obj.female
                    }
                }
            }, function(data){
                if(data.status == 'success'){
                    var player = new PlayerModel(self, {
                        id: data.id,
                        player_id: player_obj.id,
                        name: player_obj.name,
                        high_dart: true,
                        high_out: true,
                        mystery_out: true,
                        honey_pot: self.tournament.honey_pot(),
                        female: player_obj.female
                    });

                    self.players.push(player);
                    self.sortPlayers();
                }
            });
        } else {
            $("#Player_name").val(player_name);
            $("#addplayer_modal").modal('show');
            // alert("We could not find the player " + player_name);
        }
        $("#player").val('');
    };

    self.removePlayer = function(player){
        $.getJSON('/director/tournament/removeplayerfromtournament', {
            data:{
                id: player.id
            }
        }, function(data){
            if(data.status == 'success'){
                self.players.remove(player);
            }
        });
    };

    self.addXman = function(_player){
        $.getJSON('/director/tournament/addxman', {
            data: {
                tournament_id: self.tournament.id(),
                player_id: _player.player_id
            }
        }, function(data){
            if(data.status == 'success'){
                console.log(data)
                var pt = data.xman;
                var p = data.player;

                var player = new PlayerModel(self, {
                    id: pt.id,
                    player_id: pt.player_id,
                    name: p.name,
                    high_dart: false,
                    high_out: false,
                    mystery_out: false,
                    honey_pot: false,
                    female: p.female,
                    xman: true
                });

                self.players.push(player);
                self.selected_xman('');
                self.sortPlayers();
            }
        });
    };

    self.selectXman = function(){
        var random = Math.floor(Math.random() * self.players().length);
        var player = self.players()[random];
        self.selected_xman(player.player_id());
    };

    self.validateChip = function(player, event){
        var largest_chip = self.numberOfParticipants() / 2;
        var chip_pulled = player.chip_pulled();

        if(chip_pulled > largest_chip)
        {
            alert("Chip Pulled cannot be larger than " + largest_chip);
            player.chip_pulled('');
        }

        var cnt = 0;
        _.each(self.players(), function(_player){
            if(_player.chip_pulled() == chip_pulled && chip_pulled >= 1){
                cnt++;
            }
        });

        if(cnt > 2){
            alert("This chip (" + chip_pulled + ") has alread been assigned twice");
            player.chip_pulled('');
        }
    };

    self.payouts = ko.computed(function(){
        var high_dart = 0;
        var high_out = 0;
        var honey_pot = 0;
        var mystery_out = 0;

        _.each(self.players(), function(player){
            if(player.high_dart()) high_dart += parseFloat(self.tournament.high_dart_fee());
            if(player.high_out()) high_out += parseFloat(self.tournament.high_out_fee());
            if(player.mystery_out()) mystery_out += parseFloat(self.tournament.mystery_out_fee());
            if(player.honey_pot()) honey_pot += parseFloat(self.tournament.honey_pot_fee());
        });

        payout = {
            high_dart: high_dart.toFixed(2),
            high_out: high_out.toFixed(2),
            honey_pot: honey_pot.toFixed(2),
            mystery_out: mystery_out.toFixed(2)
        };

        return payout;
    }, self);

    self.suggested_payouts = ko.computed(function(){
        return Payouts(Math.floor(self.players().length / 2));
    });

    self.redrawTeams = function(){
        $("#warningModal").modal('hide');
        $.getJSON('/director/tournament/redrawteams', {
            data: {
                tournament_id: self.tournament.id(),
            }
        }, function(data){
            if(data.status == 'success'){
                self.tournament.teams_selected(false);
                _.each(self.players(), function(player){
                    player.chip_pulled('');
                });
            }
        });
    };

    return self;
};
