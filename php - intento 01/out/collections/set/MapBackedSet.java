/**
 * Decorates a <code>Map</code> to obtain <code>Set</code> behaviour.
 * <p>
 * This class is used to create a <code>Set</code> with the same properties as
 * the key set of any map. Thus, a ReferenceSet can be created by wrapping a
 * <code>ReferenceMap</code> in an instance of this class.
 * <p>
 * Most map implementation can be used to create a set by passing in dummy values.
 * Exceptions include <code>BidiMap</code> implementations, as they require unique values.
 *
 * @since Commons Collections 3.1
 * @version $Revision: 966327 $ $Date: 2010-07-21 19:39:49 +0200 (Wed, 21 Jul 2010) $
 *
 * @author Stephen Colebourne
 */
/** Serialization version */
/** The map being used as the backing store */
/** The dummyValue to use */
/**
     * Factory method to create a set from a map.
     * 
     * @param map  the map to decorate, must not be null
     * @throws IllegalArgumentException if set is null
     */
/**
     * Factory method to create a set from a map.
     * 
     * @param map  the map to decorate, must not be null
     * @param dummyValue  the dummy value to use
     * @throws IllegalArgumentException if map is null
     */
//-----------------------------------------------------------------------
/**
     * Constructor that wraps (not copies).
     * 
     * @param map  the map to decorate, must not be null
     * @param dummyValue  the dummy value to use
     * @throws IllegalArgumentException if map is null
     */
//-----------------------------------------------------------------------
