console := $(shell which bin/console)
composer := $(shell which composer)

database:
	@printf "\033[32;49m *** Initiliaze database *** \033[39m\n"
	@rm -rf public/img/offer
	@$(console) doctrine:database:create
	@$(console) make:migrations
	@$(console) doctrine:fixtures:load -n
.PHONY: database

vendor:
	@printf "\033[32;49m *** Downloading composer dependencies *** \033[39m\n"	
	@$(composer) install
.PHONY: vendor