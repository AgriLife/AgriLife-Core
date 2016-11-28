module.exports = (grunt) ->
  @initConfig
    pkg: @file.readJSON('package.json')
    watch:
      files: [
        'js/src/coffee/**.coffee',
        'js/src/*.js',
        '**/*.scss'
      ]
      tasks: ['develop']
    coffee:
      compile:
        options:
          bare: true
          sourceMap: true
        expand: true
        cwd: '/js/src/coffee'
        src: ['*.coffee']
        dest: '/js/src/'
        ext: '.js'
    compass:
      dist:
        options:
          config: 'config.rb'
          specify: ['css/src/*.scss']
    jshint:
      files: ['js/src/*.js']
      options:
        globals:
          jQuery: true
          console: true
          module: true
          document: true
        force: true
    csslint:
      options:
        'star-property-hack': false
        'duplicate-properties': false
        'unique-headings': false
        'ids': false
        'display-property-grouping': false
        'floats': false
        'outline-none': false
        'box-model': false
        'adjoining-classes': false
        'box-sizing': false
        'universal-selector': false
        'font-sizes': false
        'overqualified-elements': false
        'important': false
        'regex-selectors': false
        force: true
      src: ['css/*.css']
    concat:
      adminjs:
        src: ['js/src/admin-*.js']
        dest: 'js/admin.min.js'
      publicjs:
        src: ['js/src/public-*.js']
        dest: 'js/public.min.js'
    compress:
      main:
        options:
          archive: 'AgriLife-Core.zip'
        files: [
          {src: ['css/*.css']},
          {src: ['fields/**']},
          {src: ['js/*.js']},
          {src: ['src/**']},
          {src: ['templates/**']},
          {src: ['vendor/**', '!vendor/composer/autoload_static.php']},
          {src: ['agrilife-core.php']},
          {src: ['README.md']},
        ]
    gh_release:
      options:
        token: process.env.RELEASE_KEY
        owner: 'agrilife'
        repo: 'AgriLife-Core'
      release:
        tag_name: '<%= pkg.version %>'
        target_commitish: 'master'
        name: 'Release'
        body: 'First release'
        draft: false
        prerelease: false
        asset:
          name: 'AgriLife-Core.zip'
          file: 'AgriLife-Core.zip'
          'Content-Type': 'application/zip'

  @loadNpmTasks 'grunt-contrib-coffee'
  @loadNpmTasks 'grunt-contrib-compass'
  @loadNpmTasks 'grunt-contrib-jshint'
  @loadNpmTasks 'grunt-contrib-csslint'
  @loadNpmTasks 'grunt-contrib-concat'
  @loadNpmTasks 'grunt-contrib-watch'
  @loadNpmTasks 'grunt-contrib-compress'
  @loadNpmTasks 'grunt-gh-release'
  @loadNpmTasks 'grunt-gitinfo'

  @registerTask 'default', ['compass', 'concat']
  @registerTask 'develop', ['compass', 'jshint', 'csslint', 'concat']
  @registerTask 'package', ['default', 'csslint', 'jshint']
  @registerTask 'release', ['compress', 'setreleasemsg', 'gh_release']
  @registerTask 'setreleasemsg', 'Set release message as range of commits', ->
    done = @async()
    grunt.util.spawn {
      cmd: 'git'
      args: [ 'tag' ]
    }, (err, result, code) ->
      if(result.stdout!='')
        matches = result.stdout.match(/([^\n]+)$/)
        releaserange = matches[1] + '..HEAD'
        grunt.config.set 'releaserange', releaserange
        grunt.task.run('shortlog');
      done(err)
      return
    return
  @registerTask 'shortlog', 'Set gh_release body with commit messages since last release', ->
    done = @async()
    grunt.util.spawn {
      cmd: 'git'
      args: ['shortlog', grunt.config.get('releaserange'), '--no-merges']
    }, (err, result, code) ->
      if(result.stdout != '')
        grunt.config 'gh_release.release.body', result.stdout.replace(/(\n)\s\s+/g, '$1- ')
      else
        grunt.config 'gh_release.release.body', 'release'
      done(err)
      return
    return

  @event.on 'watch', (action, filepath) =>
    @log.writeln('#{filepath} has #{action}')
