COMPILER := compiler/cvc.py
XML := cv.xml
EXPORT := export

COMPILER_HTML_FLAGS := --image-path= --css=cv.css

RSRC := $(patsubst %.jpg, export/%.jpg,$(wildcard *.jpg)) \
	$(patsubst %.png, export/%.png,$(wildcard *.png)) \
	$(patsubst %.png, export/%.png,$(wildcard *.css)) \
	$(patsubst %.png, export/%.png,$(wildcard *.js))


all: rsrc $(EXPORT)/cv_hu.html $(EXPORT)/cv_en.html $(EXPORT)/cv_hu_embed.html $(EXPORT)/cv_en_embed.html

clean:
	rm -Rf $(EXPORT)

$(EXPORT): $(XML) $(COMPILER)
	mkdir -p $(EXPORT)

rsrc: $(EXPORT) $(RSRC)

$(EXPORT)/cv_hu.html: $(EXPORT) $(XML) 
	$(COMPILER) $(XML) $@ $(COMPILER_HTML_FLAGS) --language=hu

$(EXPORT)/cv_en.html: $(EXPORT) $(XML) 
	$(COMPILER) $(XML) $@ $(COMPILER_HTML_FLAGS) --language=en

$(EXPORT)/cv_hu_embed.html: $(EXPORT) $(XML) 
	$(COMPILER) $(XML) $@ $(COMPILER_HTML_FLAGS) --format=html-headless --language=hu

$(EXPORT)/cv_en_embed.html: $(EXPORT) $(XML) 
	$(COMPILER) $(XML) $@ $(COMPILER_HTML_FLAGS) --format=html-headless --language=en

$(EXPORT)/%: %
	cp $< $@

