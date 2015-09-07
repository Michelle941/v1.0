# Require any additional compass plugins here.
require 'sass-globbing'

# Set this to the root of your project when deployed:
http_path = "/"
css_dir = "css"
sass_dir = "scss"
images_dir = "images"
javascripts_dir = "js"

# You can select your preferred output style here (can be overridden via the command line):
output_style = :compressed #or :expanded or :nested or :compact
# To enable relative paths to assets via compass helper functions. Uncomment:
relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false


# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass

# Make a copy of sprites with a name that has no uniqueness of the hash.
on_sprite_saved do |filename|
  if File.exists?(filename)
    FileUtils.cp filename, filename.gsub(%r{-s[a-z0-9]{10}\.png$}, '.png')
  end
end

# Replace in stylesheets generated references to sprites
# by their counterparts without the hash uniqueness.
on_stylesheet_saved do |filename|
  if File.exists?(filename)
    css = File.read filename
    File.open(filename, 'w+') do |f|
      f << css.gsub(%r{-s[a-z0-9]{10}\.png}, '.png')
    end
    FileUtils.cp(filename, '../web/css')
  end
end

def decimal(value)
  unless value.is_a?(Sass::Script::Number) && value.unit_str == "%"
    raise ArgumentError.new("#{value.inspect} is not a percent")
  end
  Sass::Script::Number.new(value.value / 100.0)
end

class Sass::Tree::Visitors::Perform < Sass::Tree::Visitors::Base

  # Removes all comments completely
  def visit_comment(node)
    return []
  end

end