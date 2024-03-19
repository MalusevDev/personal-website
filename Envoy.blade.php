@include('vendor/autoload.php')

@servers(['web' => 'dmalusev@dusanmalusev.dev', 'localhost' => '127.0.0.1'])

@setup
$start = now();
$containerRegistry = "ghcr.io";
$image="ghcr.io/dmalusev/website:$version";
$staticFiles="/var/www/www.dusanmalusev.dev";
$CONTAINER_BASE_PATH="/var/www/html";
$CONTAINER_STATIC_FILES="$CONTAINER_BASE_PATH/public";
$CONTAINER_APP_LOCAL_STORAGE="$CONTAINER_BASE_PATH/storage/app";
$APP_LOCAL_STORAGE="/opt/website/storage";
$EXTRACT_PATH="/extract";
$LOGS_PATH="/var/log/website";
$storage = $STATIC_FILES . "/storage";
$dockerNetwork = "website";
@endsetup

@story('deploy', ['on' => 'web', 'confirm' => true])
@empty($version)
    echo 'Version is not set'
    exit 1
@endempty

@empty($githubToken)
    echo 'Container registry password is not set'
    exit 1
@endempty

pull-docker-image
migrate-database
extract-static-files
deploy-image
@endstory

@task('migrate-database', ['confirm' => true])
docker run \
--rm \
--network {{ $dockerNetwork }} \
--add-host=host.docker.internal:host-gateway \
--env-file "$PWD/.env" \
-it {{ $image }} php artisan migrate -n --force
@endtask

@task('pull-docker-image')
@empty($username)
    @php
        $username = 'dmalusev';
    @endphp
@endempty

docker login {{ $containerRegistry }} \
--username {{ $username }} \
--password {{ $githubToken }}

docker pull {{ $image }}
docker logout {{ $containerRegistry }}
@endtask

@task('extract-static-files')
docker run \
--name extract-static-files \
--rm \
-it \
-v "{{ $staticFiles }}:{{ $EXTRACT_PATH }}" \
{{ $image }} \
cp -a "{{ $CONTAINER_STATIC_FILES }}/." "$EXTRACT_PATH"

sudo mkdir -p {{  $STATIC_FILES }}
sudo mkdir -p {{  $APP_LOCAL_STORAGE }}
sudo mkdir -p {{  $APP_LOCAL_STORAGE . '/public' }}
sudo mkdir -p {{ $LOGS_PATH }}

@if(!file_exists($storage))
    sudo ln    -s "$APP_LOCAL_STORAGE/public" {{ $storage }}
@elseif(!is_link($storage))
    echo 'Storage is not a link'
    exit 1
@endunless
@endtask

@task('deploy-image')
docker rm -f website

docker run \
-it \
--name website \
-d \
--restart unless-stopped \
-p 8000:8080 \
--network {{ $dockerNetwork }} \
-v {{ $LOGS_PATH . ':' . $LOGS_PATH }} \
-v "$STATIC_FILES:$CONTAINER_STATIC_FILES" \
-v "$APP_LOCAL_STORAGE:$CONTAINER_APP_LOCAL_STORAGE" \
-v "$APP_LOCAL_STORAGE/public:$APP_LOCAL_STORAGE/public" \
--add-host=host.docker.internal:host-gateway \
--env-file "$PWD/.env" {{ $image }}

@endtask

@finished
echo 'Task {{ $task }} took {{ now()->diffForHumans($start) }}'
@endfinished