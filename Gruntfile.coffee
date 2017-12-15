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
    compass:
      pkg:
        options:
          config: 'config.rb'
          force: true
      dev:
        options:
          config: 'config.rb'
          force: true
          outputStyle: 'expanded'
          sourcemap: true
          noLineComments: true
    jshint:
      files: ['js/*.js']
      options:
        globals:
          jQuery: true
          console: true
          module: true
          document: true
        force: true
    sasslint:
      options:
        configFile: '.sass-lint.yml'
      target: ['css/src/*.scss']
    shell:
      vipscan:
        command: 'php wp-cli.phar vip-scanner scan-theme --theme="../plugins/AgriLife-Core" --scan_type="VIP Theme Review" --summary=0 --format=json'
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
          {src: ['vendor/**']},
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
        body: 'Release'
        draft: false
        prerelease: false
        asset:
          name: 'AgriLife-Core.zip'
          file: 'AgriLife-Core.zip'
          'Content-Type': 'application/zip'

  @loadNpmTasks 'grunt-contrib-compass'
  @loadNpmTasks 'grunt-contrib-compress'
  @loadNpmTasks 'grunt-gh-release'
  @loadNpmTasks 'grunt-contrib-jshint'
  @loadNpmTasks 'grunt-sass-lint'
  @loadNpmTasks 'grunt-contrib-watch'
  @loadNpmTasks 'grunt-shell'

  @registerTask 'default', ['sasslint', 'compass:dev']
  @registerTask 'develop', ['compass:dev', 'sasslint', 'jshint']
  @registerTask 'scan', ['shell']
  @registerTask 'package', ['compass:pkg']
  @registerTask 'release', ['compress', 'setreleasemsg', 'gh_release']
  @registerTask 'setreleasemsg', 'Set release message as range of commits', ->
    done = @async()
    grunt.util.spawn {
      cmd: 'git'
      args: [ 'tag' ]
    }, (err, result, code) ->
      if result.stdout isnt ''
        matches = result.stdout.match /([^\n]+)$/
        grunt.config.set 'lasttag', matches[1]
        grunt.task.run 'shortlog'
      done(err)
      return
    return
  @registerTask 'shortlog', 'Set gh_release body with commit messages since last release', ->
    done = @async()
    releaserange = grunt.template.process '<%= lasttag %>..HEAD'
    grunt.util.spawn {
      cmd: 'git'
      args: ['shortlog', releaserange, '--no-merges']
    }, (err, result, code) ->
      if result.stdout isnt ''
        message = result.stdout.replace /(\n)\s\s+/g, '$1- '
        message = message.replace /\s*\[skip ci\]/g, ''
        grunt.config 'gh_release.release.body', message
      done(err)
      return
    return
  @registerTask 'phpscan', 'Compare results of vip-scanner with known issues', ->
    done = @async()
    grunt.util.spawn {
      cmd: 'grunt'
      args: ['scan']
    }, (err, result, code) ->
      if result.stdout isnt ''
        grunt.log.writeln('--- VIP Scanner Results ---')
        # Display known issues info
        knownissues = grunt.file.readJSON('known-issues.json')
        grunt.log.writeln(knownissues.length + ' known issues')
        # Display current issues info
        grunt.log.writeln('Stdout string length: ' + result.stdout.length)
        grunt.log.writeln('Stdout string snippet: ' + result.stdout.substring(0,500))
        jsonstartindex = result.stdout.indexOf('[{')
        jsonendindex = result.stdout.lastIndexOf('}]')
        results = result.stdout.slice(jsonstartindex, jsonendindex) + '}]'
        currentissues = JSON.parse(results)
        grunt.log.writeln(currentissues.length + ' current issues')
        # Display new issues
        newissues = []
        i = 0
        while i < currentissues.length
          add = true
          j = 0
          while j < knownissues.length
            if currentissues[i].toString() == knownissues[j].toString()
              add = false
            j++
          if add
            newissues.push currentissues[i]
          i++
        grunt.log.writeln(newissues.length + ' new issues:')
        i = 0
        while i < newissues.length
          obj = newissues[i]
          msg = obj.level + ': '
          msg += obj.description + '('
          msg += obj.lines.join(', ') + ')'
          msg += ' in ' + obj.file
          grunt.log.writeln msg
          i++
      done(err)
      return
    return

  @event.on 'watch', (action, filepath) =>
    @log.writeln('#{filepath} has #{action}')
