SELECT COUNT(*)
FROM Players, Stats, EventTypes, Games, Teams
WHERE (
    (Players.first_name ='Cam' AND Players.last_name ='Newton')
    AND (Players.id = Stats.player_id OR Players.id = Stats.qb_id)
    AND (Stats.event_id = EventTypes.id )
    AND (Games.id = Stats.game_id AND (Games.home_id = Teams.id OR Games.away_id = Teams.id) AND Teams.team_name = 'Atlanta')
)
