# Well documented Makefiles
DEFAULT_GOAL := help
help:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z0-9_-]+:.*?##/ { printf "  \033[36m%-40s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ [Docker]
start: ## Spin up the container
	docker compose up -d

stop: ## Shut down the containers
	docker compose down

build: ## Build all docker images
	docker compose build

##@ [Application]
composer: ## Run composer commands. Specify the command e.g. via "make composer ARGS="install|update|require <dependency>"
	docker compose run --rm app composer $(ARGS)

install:
	docker compose run --rm app composer install

lint: ## Run the Linter
	docker compose run --rm app composer lint

test-lint: ## Run the Linter Test
	docker compose run --rm app composer test:lint

test-types: ## Run the PHPStan analysis
	docker compose run --rm app composer test:types

test-unit: ## Run the Pest Test Suite
	docker compose run --rm app composer test:unit

test: ## Run the tests. Apply arguments via make test ARGS="--init"
	docker compose run --rm app composer test
