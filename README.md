
<h1>JuSimpleSearchBundle</h1>

Allow to search files by content.

<h2>Installation</h2>

Download via composer:

<pre><code>composer require judim/simple-search-bundle:dev-mater
</code></pre>

Add bundle to Kernel:

<pre><code>new Ju\SimpleSearchBundle\JuSimpleSearchBundle()
</code></pre>

<h1>Usage</h1>

<pre>
<code>php app/console find &lt;string&gt; &lt;dirs&gt; [--engine=ENGINE] [--pattern=FILE_PATTERN] 
</code>
</pre>
