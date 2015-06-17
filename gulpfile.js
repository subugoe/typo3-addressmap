var gulp = require('gulp'),
	sass = require('gulp-sass'),
	scsslint = require('gulp-scss-lint'),
	bower = require('gulp-bower'),
	autoprefixer = require('gulp-autoprefixer');


var config = {
	paths: {
		bower: ['./app/bower_components/'],
		sass: ['./Resources/Private/Scss/*.scss']
	},
	autoprefixer: {
			browsers: [
				'last 2 versions',
				'safari 6',
				'ie 9',
				'opera 12.1',
				'ios 6',
				'android 4'
			],
			cascade: true
		}
};


gulp.task('sass', function () {
	gulp.src(config.paths.sass)
		.pipe(sass({
			style: 'compressed',
			errLogToConsole: true,
			sourcemaps: true
		}))
		.pipe(autoprefixer(
			config.autoprefixer
		))
		.pipe(gulp.dest('./Resources/Public/Css/'))
});

gulp.task('lint', function () {
	gulp.src(config.paths.sass)
		.pipe(scsslint({
			'reporterOutput': './Build/ScssReport.xml',
			'config': 'Build/scss-lint.yml',
			'maxBuffer': 9999999
		}))
});

gulp.task('copy-leaflet-js', function () {
	return gulp.src(config.paths.bower + 'leaflet/dist/*.js')
		.pipe(gulp.dest('Resources/Public/JavaScript/'));
});

gulp.task('copy-leaflet-css', function () {
	return gulp.src(config.paths.bower + 'leaflet/dist/*.css')
		.pipe(gulp.dest('Resources/Public/Css/'));
});

gulp.task('bower', function () {
	return bower()
		.pipe(gulp.dest(config.paths.bower[0]))
});

gulp.task('watch', function () {
	gulp.watch(config.paths.sass, ['lint', 'compile'])
});

gulp.task('compile', function () {
	gulp.start('bower', 'copy-leaflet-js', 'copy-leaflet-css', 'sass')
});

gulp.task('default', function () {
	gulp.start('lint', 'compile', 'watch')
});
