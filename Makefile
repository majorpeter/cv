COMPILER := compiler/cvc.py
XML := cv.xml
EXPORT := export

COMPILER_HTML_FLAGS := --css style.css cv.css --js https://code.jquery.com/jquery-1.12.4.min.js cv.js

RSRC := $(patsubst %.jpg, export/%.jpg,$(wildcard *.jpg)) \
	$(patsubst %.png, export/%.png,$(wildcard *.png)) \
	$(patsubst %.css, export/%.css,$(wildcard *.css)) \
	$(patsubst %.js, export/%.js,$(wildcard *.js))


all: $(EXPORT)/cv_hu.html $(EXPORT)/cv_en.html \
     $(EXPORT)/cv_hu_embed.html $(EXPORT)/cv_en_embed.html \
     $(EXPORT)/cv_hu_print.html $(EXPORT)/cv_en_print.html \
     $(RSRC)

clean:
	rm -Rf $(EXPORT)

$(EXPORT): $(XML) $(COMPILER)
	mkdir -p $(EXPORT)

rsrc: $(EXPORT) $(RSRC)

$(EXPORT)/cv_hu.html: $(COMPILER) $(XML)
	$(COMPILER) $(COMPILER_HTML_FLAGS) --language hu $(XML) $@

$(EXPORT)/cv_en.html: $(COMPILER) $(XML)
	$(COMPILER) $(COMPILER_HTML_FLAGS) --language en $(XML) $@

$(EXPORT)/cv_hu_embed.html: $(COMPILER) $(XML)
	$(COMPILER) $(COMPILER_HTML_FLAGS) --format html-headless --language hu $(XML) $@

$(EXPORT)/cv_en_embed.html: $(COMPILER) $(XML)
	$(COMPILER) $(COMPILER_HTML_FLAGS) --format html-headless --language en $(XML) $@

$(EXPORT)/cv_hu_print.html: $(COMPILER) $(XML)
	$(COMPILER) $(COMPILER_HTML_FLAGS) --format html-printable --language hu $(XML) $@

$(EXPORT)/cv_en_print.html: $(COMPILER) $(XML)
	$(COMPILER) $(COMPILER_HTML_FLAGS) --format html-printable --language en $(XML) $@

$(EXPORT)/%: %
	cp $< $@

