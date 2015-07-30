/**
 * Utilities for working with "split maps:" objects that implement {@link Put}
 * and/or {@link Get} but not {@link Map}.
 *
 * @since Commons Collections 5
 * @TODO fix version
 * @version $Revision: 899713 $ $Date: 2010-01-15 17:57:24 +0100 (Fri, 15 Jan 2010) $
 * @see Get
 * @see Put
 * @author Matt Benson
 */
/**
     * <code>SplitMapUtils</code> should not normally be instantiated.
     */
/**
     * Get the specified {@link Get} as an instance of {@link IterableMap}.
     * If <code>get</code> implements {@link IterableMap} directly, no conversion will take place.
     * If <code>get</code> implements {@link Map} but not {@link IterableMap} it will be decorated.
     * Otherwise an {@link Unmodifiable} {@link IterableMap} will be returned.
     * @param <K>
     * @param <V>
     * @param get to wrap, must not be null
     * @return {@link IterableMap}
     */
/**
     * Get the specified {@link Put} as an instanceof {@link Map}.
     * If <code>put</code> implements {@link Map} directly, no conversion will take place.
     * Otherwise a <em>write-only</em> {@link Map} will be returned.  On such a {@link Map}
     * it is recommended that the result of #put(K, V) be discarded as it likely will not
     * match <code>V</code> at runtime.
     *
     * @param <K>
     * @param <V>
     * @param put to wrap, must not be null
     * @return {@link Map}
     */
