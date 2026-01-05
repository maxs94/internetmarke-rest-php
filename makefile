SHELL := /bin/bash

#
# Makefile
#

PHP ?= php
COMPOSER ?= composer
PHPSTAN := vendor/bin/phpstan
PHP_CS_FIXER := vendor/bin/php-cs-fixer

.PHONY: help clean install phpunit csfix stan phpstan-baseline

.DEFAULT_GOAL := help

help:
	@grep -hE '^[0-9a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

clean: ## Cleans all dependencies
	rm -rf vendor/*

install: ## Installs all dependencies
	- rm install.lock || true
	- rm vendor/autoload.php || true
	$(COMPOSER) install --no-interaction --optimize-autoloader --no-suggest
	touch install.lock

phpunit: ## Starts all tests
ifndef filter
	@$(PHP) vendor/bin/phpunit --configuration=phpunit.xml
else
	@$(PHP) vendor/bin/phpunit --configuration=phpunit.xml --filter $(filter)
endif

csfix: ## Starts the PHP CS Fixer [mode=dry-run] default is no-dry-run
ifndef mode
	@$(PHP) ./$(PHP_CS_FIXER) fix --config=.php_cs.php
else ifeq ($(mode),dry-run)
	@$(PHP) ./$(PHP_CS_FIXER) fix --config=.php_cs.php --dry-run
else
	@$(PHP) ./$(PHP_CS_FIXER) fix --config=.php_cs.php $(mode)
endif

stan: ## Starts the PHPStan analyser. Use changesonly=1 to analyse uncommitted/staged changes, lastcommit=1 to analyse files from last commit
	@echo "Running PHPStan..."
ifdef changesonly
	@FILES="$$(git diff --name-only --diff-filter=MARC) $$(git diff --name-only --cached --diff-filter=MARC)"; \
	if [ -n "$$FILES" ]; then \
		$(PHP) $(PHPSTAN) --memory-limit=-1 analyse -c phpstan.neon $$FILES; \
	else \
		echo "No changed files detected; running full analysis."; \
		$(PHP) $(PHPSTAN) --memory-limit=-1 analyse -c phpstan.neon; \
	fi
else ifdef lastcommit
	@FILES="$$(git diff --name-only HEAD~1..HEAD)"; \
	if [ -n "$$FILES" ]; then \
		$(PHP) $(PHPSTAN) --memory-limit=-1 analyse -c phpstan.neon $$FILES; \
	else \
		echo "No changes in last commit; running full analysis."; \
		$(PHP) $(PHPSTAN) --memory-limit=-1 analyse -c phpstan.neon; \
	fi
else
	@$(PHP) $(PHPSTAN) --memory-limit=-1 analyse -c phpstan.neon
endif

phpstan-baseline: ## Generate a PHPStan baseline file (writes phpstan-baseline.neon)
	@echo "Generating PHPStan baseline..."
	@$(PHP) $(PHPSTAN) --memory-limit=-1 analyse -c phpstan.neon --generate-baseline
	@echo "Baseline written to phpstan-baseline.neon"
