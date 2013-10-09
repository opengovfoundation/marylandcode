
namespace :world do
  apps = [
    'www',
    'charter'
  ]

  task :deploy do
    env = ENV['ENV'] || 'staging'
    apps.each do |app|
      Capistrano::CLI.ui.say "deploying #{app}:#{env}"
      system("cap #{app}:#{env} deploy")
    end;
  end


  task :setup do
    env = ENV['ENV'] || 'staging'
    apps.each do |app|
      Capistrano::CLI.ui.say "setting up #{app}:#{env}"
      system("cap #{app}:#{env} deploy:setup")
    end;
  end

end

