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
        # 'ids': false
        'display-property-grouping': false
        'floats': false
        'outline-none': false
        'box-model': false
        'adjoining-classes': false
        'box-sizing': false
        'universal-selector': false
        'font-sizes': false
        'overqualified-elements': false
        force: true
      src: ['css/*.css']
    concat:
      adminjs:
        src: ['js/src/admin-*.js']
        dest: 'js/admin.min.js'
      publicjs:
        src: ['js/src/public-*.js']
        dest: 'js/public.min.js'

  @loadNpmTasks 'grunt-contrib-coffee'
  @loadNpmTasks 'grunt-contrib-compass'
  @loadNpmTasks 'grunt-contrib-jshint'
  @loadNpmTasks 'grunt-contrib-csslint'
  @loadNpmTasks 'grunt-contrib-concat'
  @loadNpmTasks 'grunt-contrib-watch'

  @registerTask 'default', ['compass', 'concat']
  @registerTask 'develop', ['compass', 'jshint', 'csslint', 'concat']
  @registerTask 'package', ['default', 'cssmin', 'csslint']

  @event.on 'watch', (action, filepath) =>
    @log.writeln('#{filepath} has #{action}')