/**
 * Decorates another <code>Map</code> to transform objects that are added.
 * <p>
 * The Map put methods and Map.Entry setValue method are affected by this class.
 * Thus objects must be removed or searched for using their transformed form.
 * For example, if the transformation converts Strings to Integers, you must use
 * the Integer form to remove objects.
 * <p>
 * <strong>Note that TransformedMap is not synchronized and is not
 * thread-safe.</strong> If you wish to use this map from multiple threads
 * concurrently, you must use appropriate synchronization. The simplest approach
 * is to wrap this map using {@link java.util.Collections#synchronizedMap(Map)}.
 * This class may throw exceptions when accessed by concurrent threads without
 * synchronization.
 * <p>
 * The "put" and "get" type constraints of this class are mutually independent;
 * contrast with {@link org.apache.commons.collections.map.TransformedMap} which,
 * by virtue of its implementing {@link Map}&lt;K, V&gt;, must be constructed in such
 * a way that its read and write parameters are generalized to a common (super-)type.
 * In practice this would often mean <code>&gt;Object, Object&gt;</code>, defeating
 * much of the usefulness of having parameterized types.
 * <p>
 * On the downside, this class is not a drop-in replacement for {@link java.util.Map}
 * but is intended to be worked with either directly or by {@link Put} and {@link Get}
 * generalizations.
 *
 * @since Commons Collections 5
 * @TODO fix version
 * @version $Revision: 966368 $ $Date: 2010-07-21 21:07:52 +0200 (Wed, 21 Jul 2010) $
 *
 * @author Stephen Colebourne
 * @author Matt Benson
 */
/** Serialization version */
/** The transformer to use for the key */
/** The transformer to use for the value */
/**
     * Factory method to create a transforming map.
     * <p>
     * If there are any elements already in the map being decorated, they are
     * NOT transformed.
     *
     * @param map the map to decorate, must not be null
     * @param keyTransformer the transformer to use for key conversion, null
     * means no transformation
     * @param valueTransformer the transformer to use for value conversion, null
     * means no transformation
     * @throws IllegalArgumentException if map is null
     */
//-----------------------------------------------------------------------
/**
     * Constructor that wraps (not copies).
     * <p>
     * If there are any elements already in the collection being decorated, they
     * are NOT transformed.
     *
     * @param map the map to decorate, must not be null
     * @param keyTransformer the transformer to use for key conversion, null
     * means no conversion
     * @param valueTransformer the transformer to use for value conversion, null
     * means no conversion
     * @throws IllegalArgumentException if map is null
     */
//-----------------------------------------------------------------------
/**
     * Write the map out using a custom routine.
     *
     * @param out the output stream
     * @throws IOException
     */
/**
     * Read the map in using a custom routine.
     *
     * @param in the input stream
     * @throws IOException
     * @throws ClassNotFoundException
     * @since Commons Collections 3.1
     */
//-----------------------------------------------------------------------
/**
     * Transforms a key.
     * <p>
     * The transformer itself may throw an exception if necessary.
     *
     * @param object the object to transform
     * @throws the transformed object
     */
/**
     * Transforms a value.
     * <p>
     * The transformer itself may throw an exception if necessary.
     *
     * @param object the object to transform
     * @throws the transformed object
     */
/**
     * Transforms a map.
     * <p>
     * The transformer itself may throw an exception if necessary.
     *
     * @param map the map to transform
     * @throws the transformed object
     */
/**
     * Override to transform the value when using <code>setValue</code>.
     *
     * @param value the value to transform
     * @return the transformed value
     */
//-----------------------------------------------------------------------
/**
     * {@inheritDoc}
     */
/**
     * {@inheritDoc}
     */
/**
     * {@inheritDoc}
     */
