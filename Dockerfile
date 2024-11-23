# manually changing owner
COPY . $APP_HOME
RUN chown -r app:app $APP_HOME

# using --chown option
COPY --chown=app:app . $APP_HOME

# install vendors
CMD bash -c "composer install"

# migrate databases
CMD bash -c "php artisan migrate"
