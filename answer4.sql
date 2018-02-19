SELECT Teams.team_name
FROM Teams,(SELECT Games.winner_id
      FROM Teams, Games
      WHERE (Games.game_date = '2016-11-24')
      AND ((Games.home_id = Teams.id)
         AND (Teams.team_name = 'Washington' OR Teams.team_name = 'Dallas'))
      )AS Winner
WHERE Winner.winner_id = Teams.id
